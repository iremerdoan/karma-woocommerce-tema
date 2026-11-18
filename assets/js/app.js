/* Karma teması — etkileşimler: mobil menü, arama, galeri, renk/beden seçici. */
(function () {
  'use strict';

  /* ---------- Aç / kapat (mobil menü, arama paneli) ---------- */
  function ac(id, durum) {
    var el = document.getElementById(id);
    if (!el) return;
    var acik = typeof durum === 'boolean' ? durum : el.classList.contains('hidden');
    el.classList.toggle('hidden', !acik);
    document.querySelectorAll('[data-ac="' + id + '"]').forEach(function (b) {
      b.setAttribute('aria-expanded', acik ? 'true' : 'false');
    });
    if (id === 'mobil-menu') document.documentElement.classList.toggle('overflow-hidden', acik);
    if (acik) {
      var ilk = el.querySelector('input, a, button:not([data-kapat])');
      if (ilk) ilk.focus();
    }
  }

  document.addEventListener('click', function (e) {
    var a = e.target.closest('[data-ac]');
    if (a) { ac(a.getAttribute('data-ac')); return; }
    var k = e.target.closest('[data-kapat]');
    if (k) ac(k.getAttribute('data-kapat'), false);
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { ac('mobil-menu', false); ac('arama-paneli', false); }
  });

  // Masaüstüne geçince mobil menüyü kapat
  var lg = window.matchMedia('(min-width: 1024px)');
  (lg.addEventListener ? lg.addEventListener.bind(lg, 'change') : lg.addListener.bind(lg))(function (m) {
    if (m.matches) ac('mobil-menu', false);
  });

  /* ---------- Ürün galerisi ---------- */
  var anaGorsel = document.querySelector('[data-ana-gorsel]');
  var ilkKaynak = anaGorsel ? { src: anaGorsel.src, srcset: anaGorsel.getAttribute('srcset') || '' } : null;

  function gorselDegistir(src, srcset) {
    if (!anaGorsel || !src) return;
    anaGorsel.src = src;
    if (srcset) anaGorsel.setAttribute('srcset', srcset); else anaGorsel.removeAttribute('srcset');
  }

  document.querySelectorAll('[data-kucuk-gorsel]').forEach(function (btn, i, hepsi) {
    btn.addEventListener('click', function () {
      gorselDegistir(btn.dataset.src, btn.dataset.srcset);
      hepsi.forEach(function (b) {
        var secili = b === btn;
        b.setAttribute('aria-pressed', secili ? 'true' : 'false');
        b.classList.toggle('border-espresso', secili);
        b.classList.toggle('border-transparent', !secili);
      });
    });
  });

  /* ---------- Renk ve beden seçici ----------
     WooCommerce'in açılır listelerini (select) butonlara dönüştürür.
     Select gizli kalır; seçim ona yazılır, böylece WooCommerce normal çalışır. */
  var RENKLER = {
    krem: '#efe3d0', bej: '#c9ad8c', kahve: '#6b4630', kahverengi: '#6b4630', camel: '#b07a4a', karamel: '#8a5a3b',
    siyah: '#1f1a17', beyaz: '#fbfaf7', ekru: '#f2ead8', gri: '#9a9590', antrasit: '#3d3d3d', lacivert: '#1f2a44',
    mavi: '#4a6fa5', 'acik-mavi': '#a9c2dc', yesil: '#4d6b4a', haki: '#7a7550', zeytin: '#5f5b37', kirmizi: '#a53a2f',
    bordo: '#6b1f2a', pembe: '#e3b5b5', pudra: '#e8cfc6', mor: '#6d4e7a', lila: '#b9a6c9', sari: '#e2c25b', hardal: '#c49a2c',
    turuncu: '#d27a3c', kiremit: '#b3563a', vizon: '#a39282', taba: '#9a6234', 'koyu-mavi': '#24375e'
  };

  function slug(s) {
    return String(s).toLocaleLowerCase('tr').trim()
      .replace(/ı/g, 'i').replace(/ğ/g, 'g').replace(/ü/g, 'u').replace(/ş/g, 's').replace(/ö/g, 'o').replace(/ç/g, 'c')
      .replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
  }

  function seciciKur(form) {
    form.querySelectorAll('table.variations select').forEach(function (select) {
      var renkMi = /renk|color|colour/i.test(select.name);
      var satir = select.closest('tr');
      var etiket = satir && satir.querySelector('th label');
      var etiketMetni = etiket ? etiket.textContent.trim() : '';
      var secimYazisi = document.createElement('span');
      secimYazisi.className = 'font-normal';
      if (etiket && renkMi) etiket.appendChild(secimYazisi);

      var kutu = document.createElement('div');
      kutu.className = renkMi ? 'flex flex-wrap gap-[14px] p-[3px]' : 'flex flex-wrap gap-2';
      kutu.setAttribute('role', 'group');
      kutu.setAttribute('aria-label', etiketMetni);

      var butonlar = [];
      // Bedenleri doğru sıraya koy (XS, S, M, L, XL… / 36, 38, 40…)
      var SIRA = ['xxs', 'xs', 's', 'm', 'l', 'xl', 'xxl', '2xl', '3xl', '4xl'];
      function sira(o) {
        var t = o.textContent.trim().toLowerCase();
        var i = SIRA.indexOf(t);
        if (i > -1) return i;
        var n = parseFloat(t);
        return isNaN(n) ? 1000 : 100 + n;
      }
      var secenekler = Array.prototype.filter.call(select.options, function (o) { return o.value; });
      if (!renkMi) secenekler.sort(function (a, b) { return sira(a) - sira(b); });
      secenekler.forEach(function (opt) {
        var b = document.createElement('button');
        b.type = 'button';
        b.dataset.deger = opt.value;
        b.dataset.ad = opt.textContent.trim();
        b.setAttribute('aria-pressed', 'false');
        if (renkMi) {
          b.className = 'secici-renk';
          b.style.backgroundColor = RENKLER[slug(opt.value)] || RENKLER[slug(opt.textContent)] || '#d9cbbb';
          b.setAttribute('aria-label', b.dataset.ad);
          b.title = b.dataset.ad;
        } else {
          b.className = 'secici-beden';
          b.textContent = b.dataset.ad;
        }
        b.addEventListener('click', function () {
          select.value = select.value === opt.value ? '' : opt.value;
          select.dispatchEvent(new Event('change', { bubbles: true }));
          esitle();
        });
        butonlar.push(b);
        kutu.appendChild(b);
      });

      select.classList.add('sr-only');
      select.setAttribute('tabindex', '-1');
      select.setAttribute('aria-hidden', 'true');
      select.parentNode.insertBefore(kutu, select);

      function esitle() {
        var mevcut = {};
        Array.prototype.forEach.call(select.options, function (o) {
          if (o.value && !o.disabled) mevcut[o.value] = true;
        });
        var secili = null;
        butonlar.forEach(function (b) {
          var on = b.dataset.deger === select.value;
          if (on) secili = b;
          b.setAttribute('aria-pressed', on ? 'true' : 'false');
          b.disabled = !mevcut[b.dataset.deger];
        });
        secimYazisi.textContent = secili ? ': ' + secili.dataset.ad : '';
      }

      select.addEventListener('change', esitle);
      esitle();
      form._karmaEsitle = form._karmaEsitle || [];
      form._karmaEsitle.push(esitle);
    });

    // WooCommerce olayları jQuery ile geliyor
    if (window.jQuery) {
      var $f = window.jQuery(form);
      $f.on('woocommerce_update_variation_values reset_data', function () {
        (form._karmaEsitle || []).forEach(function (f) { f(); });
      });
      // Seçilen varyasyonun görseli
      $f.on('found_variation', function (e, v) {
        if (v && v.image && v.image.src) gorselDegistir(v.image.src, v.image.srcset);
      });
      $f.on('reset_image', function () {
        if (ilkKaynak) gorselDegistir(ilkKaynak.src, ilkKaynak.srcset);
      });
    }
  }

  document.querySelectorAll('.karma-sepet-formu form.variations_form').forEach(seciciKur);

  /* ---------- Bülten formu ----------
     Henüz bir e-posta servisine bağlı değil (Mailchimp, Brevo vb. bağlanınca burası kaldırılır). */
  document.querySelectorAll('form[data-bulten]').forEach(function (f) {
    f.addEventListener('submit', function (e) {
      e.preventDefault();
      var btn = f.querySelector('button');
      if (btn) { btn.textContent = 'Teşekkürler!'; btn.disabled = true; }
    });
  });
})();

/* Kategori seçeneklerinde seçili olanı görünür alana kaydır (telefonda yana kayan liste). */
(function () {
  var secili = document.querySelector('nav [aria-current="page"].rounded-full');
  if (secili && secili.scrollIntoView) secili.scrollIntoView({ block: 'nearest', inline: 'center' });
})();
