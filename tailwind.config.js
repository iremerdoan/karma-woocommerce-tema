/** Karma teması — Tailwind ayarları.
 *  Renkler ve yazı tipleri Figma'daki "Karma Web Sitesi" değişkenlerinden alındı.
 *  @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./*.php', './inc/**/*.php', './template-parts/**/*.php', './woocommerce/**/*.php', './assets/js/**/*.js'],
  theme: {
    extend: {
      colors: {
        krem: '#f7f1ea',          // arka-plan/krem
        espresso: '#3b2a20',      // metin/espresso
        karamel: '#8a5a3b',       // vurgu/karamel
        ikincil: '#6e5848',       // metin/ikincil
        'cizgi-acik': '#e3d6c8',  // çizgi/açık
        'cizgi-orta': '#c9b6a3',  // çizgi/orta
        'cizgi-koyu': '#5a4537',  // alt bilgi ayracı
        'acik-bej': '#efe5da',    // yüzey/açık-bej
        bej: '#eadfd3',           // yüzey/bej
        beyaz: '#fffdfa',         // yüzey/beyaz
        gorsel: '#e3d3c2',        // yüzey/görsel
        kampanya: '#f3ede6',      // kampanya kartı
      },
      fontFamily: {
        serif: ['"Cormorant Garamond"', 'Georgia', 'serif'],
        sans: ['"DM Sans"', 'system-ui', 'sans-serif'],
      },
      fontSize: {
        // Figma metin stilleri
        kucuk: ['14px', { lineHeight: '1.5' }],        // Metin/Küçük
        normal: ['16px', { lineHeight: '1.6' }],       // Metin/Normal
        buyuk: ['18px', { lineHeight: '1.6' }],        // Metin/Büyük
        etiket: ['13px', { lineHeight: '1.4', letterSpacing: '0.16em' }], // Etiket/Üst Başlık
        fiyat: ['22px', { lineHeight: '1.4' }],        // Metin/Fiyat
        h3: ['36px', { lineHeight: '1.2' }],           // Başlık/H3
        h2: ['40px', { lineHeight: '1.2' }],           // Başlık/H2
        'h1-urun': ['44px', { lineHeight: '1.1' }],    // Başlık/H1 Ürün
        display: ['64px', { lineHeight: '1.05' }],     // Başlık/Display
        dev: ['76px', { lineHeight: '1' }],         // Kampanya başlığı
      },
      maxWidth: {
        site: '1248px', // 1200px içerik + 2×24px kenar boşluğu
      },
    },
  },
  plugins: [],
};
