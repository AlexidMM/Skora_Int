// Obtener el botón del carrito
const cartButton = document.querySelector('.links a[href=""]');

// Agregar evento al botón del carrito
cartButton.addEventListener('click', (e) => {
    e.preventDefault();
    // Mostrar modal
    const modal = document.getElementById('modal');
    modal.style.display = 'block';
});

// Obtener el modal
const modal = document.getElementById('modal');

// Agregar evento al botón de cierre del modal
const closeButton = document.getElementById('close-button');
closeButton.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Actualizar contador de productos en el carrito
const cartCount = document.getElementById('cart-count');
cartCount.textContent = `(${Object.keys(<?php echo json_encode($_SESSION['carrito']); ?>).length})`;