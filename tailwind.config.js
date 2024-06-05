module.exports = {
  content: [
    './index.html',
    './src/**/*.{js,ts,jsx,tsx,vue}',
  ],
  theme: {
    fontFamily: {
      sans: ['Squad Latin', 'sans-serif'],
    },
    extend: {
      colors: {
        // UI
        primary: '#FF4D00',
        secondary: '#2B2D3C',
        success: '#2CC990',
        info: '#2C85F3',
        danger: '#FD2C7C',

        // Chests
        common: '#0588FF',
        rare: '#F3931D',
        epic: '#9C37FF',
      },
    },
  },
}
