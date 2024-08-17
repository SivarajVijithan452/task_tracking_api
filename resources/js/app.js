// Import Pusher and Echo
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Initialize Echo
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '57a67e28f1405a6ad04b',
    cluster: 'ap2',
    encrypted: true,
});

// Listen for the 'product.updated' event
window.Echo.channel('products')
    .listen('.product.updated', (event) => {
        console.log('Product Updated:', event.product);

        // Create a notification element
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.innerText = `Product updated: ${event.product.name}`;

        // Append notification to the body
        document.body.appendChild(notification);

        // Remove notification after some time
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 5000);
    });
