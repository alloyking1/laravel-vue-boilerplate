<template>
    <svg class="w-24 h-24 mx-auto mb-6" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="celebration-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:#22c55e;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#16a34a;stop-opacity:1" />
            </linearGradient>
        </defs>

        <!-- Main circle with gradient -->
        <circle cx="50" cy="50" r="45" fill="url(#celebration-gradient)" opacity="0.1" />
        <circle cx="50" cy="50" r="38" fill="url(#celebration-gradient)" />

        <!-- Checkmark -->
        <path d="M 30 50 L 42 62 L 70 34" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"
            fill="none" />

        <!-- Decorative circles -->
        <circle cx="20" cy="25" r="3" fill="#22c55e" opacity="0.6" />
        <circle cx="80" cy="30" r="4" fill="#16a34a" opacity="0.5" />
        <circle cx="15" cy="70" r="2.5" fill="#22c55e" opacity="0.7" />
        <circle cx="85" cy="75" r="3.5" fill="#16a34a" opacity="0.6" />
    </svg>
</template>

<script setup lang="ts">
// No props or logic needed for this static icon
</script>
