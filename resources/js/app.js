import './bootstrap';
// import Swiper JS
import Swiper from 'swiper/bundle';

document.addEventListener('DOMContentLoaded', () => {
    initializeSwiper();
});

document.addEventListener('livewire:navigated', () => {
    initializeSwiper();
});

function initializeSwiper() {
    const swiper = new Swiper('.swiper', {
        effect: 'coverflow',
        coverflowEffect: {
            rotate: 30,
            slideShadows: false,
        },
        direction: 'horizontal',
        loop: true,

        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            // when window width is >= 700px
            700: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            // when window width is >= 1000px
            1000: {
                slidesPerView: 3,
                spaceBetween: 40
            }
        }
    });
}
