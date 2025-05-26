<template>
    <section class="main-section">
        <div class="cart-container">
            <h1 class="cart-title">Ваша Корзина</h1>

            <div v-if="cartItems.length > 0" class="cart-content">
                <div class="cart-items-list">
                    <div v-for="item in cartItems" :key="item.cart_item_id" class="cart-item">
                        <img :src="`/images/${item.image}`" :alt="item.name" class="cart-item-image">
                        <div class="cart-item-details">
                            <Link :href="`/products/${item.id}`" class="cart-item-name">{{ item.name }}</Link>
                            <div class="cart-item-price">{{ item.price }} р.</div>
                            <div class="cart-item-quantity">
                                Количество:
                                <input
                                    type="number"
                                    min="1"
                                    v-model.number="item.quantity"
                                    @change="updateCartItemQuantity(item.cart_item_id, item.quantity)"
                                    class="quantity-input"
                                />
                            </div>
                            <div class="cart-item-total">
                                Сумма: {{ item.item_total }} р.
                            </div>
                            <button @click="removeCartItem(item.cart_item_id)" class="remove-item-button">
                                Удалить
                            </button>
                        </div>
                    </div>
                </div>

                <div class="cart-summary">
                    <div class="summary-total">
                        Итого: <span class="total-amount">{{ cartTotal }}</span> р.
                    </div>
                    <button class="checkout-button">Оформить заказ</button>
                    <Link href="/catalog" class="continue-shopping">Продолжить покупки</Link>
                </div>
            </div>

            <div v-else class="empty-cart-message">
                <p>Ваша корзина пуста.</p>
                <Link href="/catalog" class="go-to-catalog-button">Перейти в каталог</Link>
            </div>
        </div>
    </section>
</template>

<script>
import { Link, useForm } from '@inertiajs/vue3';

export default {
    components: {
        Link,
    },
    props: {
        cartItems: {
            type: Array,
            required: true,
            default: () => []
        },
        cartTotal: {
            type: Number,
            required: true,
            default: 0
        }
    },
    setup() {
        const updateForm = useForm({
            cart_item_id: null, // Изменено на cart_item_id
            quantity: null,
        });

        const removeForm = useForm({
            cart_item_id: null, // Изменено на cart_item_id
        });

        const updateCartItemQuantity = (cartItemId, newQuantity) => {
            if (newQuantity < 1) {
                alert('Количество должно быть не менее 1');
                return;
            }
            updateForm.cart_item_id = cartItemId; // Используем cartItemId
            updateForm.quantity = newQuantity;
            updateForm.post(route('cart.update'), {
                preserveScroll: true,
                onSuccess: () => {
                    // Inertia автоматически обновит props, так что перезагружать страницу не нужно
                },
                onError: (errors) => {
                    console.error("Ошибка при обновлении количества:", errors);
                },
            });
        };

        const removeCartItem = (cartItemId) => {
            if (confirm('Вы уверены, что хотите удалить этот товар из корзины?')) {
                removeForm.cart_item_id = cartItemId; // Используем cartItemId
                removeForm.post(route('cart.remove'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        // Inertia автоматически обновит props
                    },
                    onError: (errors) => {
                        console.error("Ошибка при удалении товара:", errors);
                    },
                });
            }
        };

        return {
            updateCartItemQuantity,
            removeCartItem,
        };
    }
}
</script>

<style scoped>
.main-section {
    color: white;
    font-family: "Montserrat";
    width: 100%;
    min-height: 100vh;
    padding: 20px;
    box-sizing: border-box;
    display: flex;
    justify-content: center;
    padding-top: 50px;
}

.cart-container {
    max-width: 1000px;
    width: 100%;
    background-color: #2c2c2c;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.cart-title {
    font-size: 36px;
    color: #ffd700;
    text-align: center;
    margin-bottom: 40px;
}

.cart-content {
    display: flex;
    gap: 30px;
    flex-wrap: wrap; /* Для адаптивности */
}

.cart-items-list {
    flex: 3; /* Занимает большую часть ширины */
    min-width: 300px; /* Минимальная ширина для списка товаров */
}

.cart-item {
    display: flex;
    align-items: center;
    background-color: #3a3a3a;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.cart-item-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 5px;
    margin-right: 20px;
    border: 1px solid #555;
}

.cart-item-details {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.cart-item-name {
    font-size: 20px;
    font-weight: bold;
    color: #ffd700;
    text-decoration: none;
    transition: color 0.2s ease;
}

.cart-item-name:hover {
    color: #ffe03b;
}

.cart-item-price, .cart-item-total {
    font-size: 18px;
    color: #e0e0e0;
}

.cart-item-total {
    font-weight: bold;
    color: #ffd700;
}

.cart-item-quantity {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
}

.quantity-input {
    width: 70px;
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #555;
    background-color: #444;
    color: white;
    font-size: 16px;
    text-align: center;
}

.remove-item-button {
    background-color: #dc3545;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.2s ease;
    margin-top: 10px;
}

.remove-item-button:hover {
    background-color: #c82333;
}

.cart-summary {
    flex: 1; /* Занимает оставшуюся часть ширины */
    min-width: 250px; /* Минимальная ширина для сводки */
    background-color: #3a3a3a;
    border-radius: 8px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    height: fit-content; /* Чтобы не растягивался на всю высоту */
}

.summary-total {
    font-size: 24px;
    font-weight: bold;
    color: #ffd700;
}

.total-amount {
    font-size: 28px;
    color: #ffd700;
}

.checkout-button {
    background-color: #28a745;
    color: white;
    padding: 15px 30px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
}

.checkout-button:hover {
    background-color: #218838;
}

.continue-shopping {
    color: #007bff;
    text-decoration: none;
    font-size: 16px;
    transition: color 0.2s ease;
}

.continue-shopping:hover {
    color: #0056b3;
}

.empty-cart-message {
    text-align: center;
    font-size: 24px;
    color: #ccc;
    padding: 50px;
}

.go-to-catalog-button {
    display: inline-block;
    background-color: #884535;
    color: white;
    padding: 12px 25px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-size: 18px;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

.go-to-catalog-button:hover {
    background-color: #a05e4a;
}

/* Адаптация для мобильных устройств */
@media (max-width: 768px) {
    .cart-content {
        flex-direction: column;
    }

    .cart-items-list, .cart-summary {
        min-width: unset;
        width: 100%;
    }

    .cart-summary {
        margin-top: 30px;
    }

    .cart-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .cart-item-image {
        margin-bottom: 15px;
        margin-right: 0;
    }
}
</style>