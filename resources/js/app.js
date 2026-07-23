import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Toast Notification System
window.showToast = function (message, type = "success") {
    const container = document.getElementById("toast-container");
    if (!container) return;

    const icons = {
        success:
            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        error: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        warning:
            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>',
        info: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
    };

    const colors = {
        success: "bg-green-500",
        error: "bg-red-500",
        warning: "bg-yellow-500",
        info: "bg-blue-500",
    };

    const toast = document.createElement("div");
    toast.className = `flex items-center gap-3 px-4 py-3 ${colors[type]} text-white rounded-lg shadow-lg transform transition-all duration-500 animate-slide-down`;
    toast.innerHTML = `
        ${icons[type] || icons.info}
        <span class="text-sm font-medium">${message}</span>
        <button onclick="this.closest('.toast-item').remove()" class="ml-2 hover:opacity-75">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;
    toast.classList.add("toast-item");
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = "0";
        toast.style.transform = "translateX(100px)";
        setTimeout(() => toast.remove(), 500);
    }, 4000);
};

// Cart Count Update
function updateCartCount() {
    fetch("/cart/count")
        .then((res) => res.json())
        .then((data) => {
            const badge = document.getElementById("cart-count");
            if (badge) badge.textContent = data.count || 0;
        })
        .catch(() => {});
}

// Add to Cart Function
window.addToCart = function (productId, quantity = 1) {
    fetch("/cart/add", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: JSON.stringify({ product_id: productId, quantity: quantity }),
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.success) {
                updateCartCount();
                showToast("Product added to cart!", "success");
            } else {
                showToast(data.message || "Failed to add to cart", "error");
            }
        })
        .catch(() => showToast("Failed to add to cart", "error"));
};

// Initialize on page load
document.addEventListener("DOMContentLoaded", function () {
    updateCartCount();
});

/****************************
  Swiper Slider
****************************/
import Swiper from "swiper";
import { FreeMode, Navigation, Thumbs } from "swiper/modules";
import "swiper/css";
import "swiper/css/free-mode";
import "swiper/css/navigation";
import "swiper/css/thumbs";

//Product Thumbs Slider
const productThumbSlider = new Swiper(".productThumbSlider", {
    modules: [Navigation],
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
    navigation: {
        nextEl: ".productThumbSlider-next",
        prevEl: ".productThumbSlider-prev",
    },
});
const productThumbSlider2 = new Swiper(".productThumbSlider2", {
    modules: [FreeMode, Thumbs],
    spaceBetween: 10,
    thumbs: {
        swiper: productThumbSlider,
    },
});
