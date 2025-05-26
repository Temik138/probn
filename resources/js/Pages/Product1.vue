<template>
    <section class="main-section">
        <div class="product-detail-container">
            <div v-if="productData" class="product-card-detail">
                <div class="image-gallery">
                    <img v-if="mainImage" :src="`/images/${mainImage}`" :alt="productData.name" class="main-product-image">
                    <div class="thumbnail-row">
                        <img
                            v-for="(img, index) in productData.images"
                            :key="index"
                            :src="`/images/${img}`"
                            @click="setMainImage(img)"
                            :class="['thumbnail', { 'active-thumbnail': mainImage === img }]"
                            alt="Product thumbnail"
                        />
                    </div>
                </div>
                <div class="product-info">
                    <h1 class="title-detail">{{ productData.name }}</h1>
                    <p class="description">{{ productData.description }}</p>
                    <div class="price-detail">{{ productData.price }}р</div>

                    <div class="add-to-cart-section">
                        <template v-if="isAuthenticated">
                            <label for="quantity-input">Количество:</label>
                            <input
                                id="quantity-input"
                                type="number"
                                min="1"
                                v-model.number="form.quantity"
                                class="quantity-selector"
                            />
                            <button @click="addToCart" :disabled="form.processing" class="add-to-cart-button">
                                Добавить в корзину
                            </button>
                        </template>
                        <template v-else>
                            <p class="auth-message">
                                <Link :href="route('login')" class="login-prompt-link">Войдите</Link> или
                                <Link :href="route('register')" class="register-prompt-link">Зарегистрируйтесь</Link>, чтобы добавить товар в корзину.
                            </p>
                        </template>
                    </div>
                </div>
            </div>
            <div v-else class="loading-message">
                Загрузка информации о товаре...
            </div>
        </div>
    </section>
</template>

<script>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export default {
    components: {
        Link,
    },
    props: {
        productData: {
            type: Object,
            required: true,
            default: () => ({})
        }
    },
    // Удаляем quantity из data(), так как теперь оно будет в useForm
    data() {
        return {
            mainImage: this.productData.image || (this.productData.images && this.productData.images.length > 0 ? this.productData.images[0] : null),
        };
    },
    setup(props) {
        // Инициализируем form здесь, чтобы использовать useForm в setup
        const form = useForm({
            product_id: props.productData.id,
            quantity: 1, // Количество по умолчанию
        });

        // Доступ к данным страницы Inertia
        const page = usePage();
       const isAuthenticated = computed(() => !!page.props.auth.user); // Используем Vue.computed для реактивности

        // Возвращаем form и isAuthenticated, чтобы они были доступны в шаблоне
        return { form, isAuthenticated };
    },
    watch: {
        productData: {
            handler(newVal) {
                if (newVal) {
                    this.mainImage = newVal.image || (newVal.images && newVal.images.length > 0 ? newVal.images[0] : null);
                    // Обновляем product_id в форме, если productData меняется
                    if (this.form) { // Проверяем, что form уже инициализирован
                        this.form.product_id = newVal.id;
                    }
                }
            },
            deep: true,
            immediate: true
        }
    },
    methods: {
        setMainImage(image) {
            this.mainImage = image;
        },
        addToCart() {
            // Проверка на авторизацию на стороне клиента
            if (!this.isAuthenticated) {
                // Это сообщение не должно показываться, так как кнопка будет скрыта/недоступна,
                // но это как запасной вариант.
                alert('Пожалуйста, авторизуйтесь, чтобы добавить товар в корзину.');
                return;
            }

            // `this.form` доступен, потому что мы его вернули из setup
            this.form.post(route('cart.add'), {
                onSuccess: () => {
                    alert('Товар успешно добавлен в корзину!');
                    // Опционально: перенаправить пользователя в корзину или показать уведомление
                    // Inertia.visit(route('cart.index'));
                    // Сбросить количество после успешного добавления
                    this.form.quantity = 1;
                },
                onError: (errors) => {
                    console.error('Ошибка при добавлении в корзину:', errors);
                    alert('Произошла ошибка при добавлении товара в корзину.');
                }
            });
        }
    },
    // Добавьте `computed` для доступа к user, если вы не используете setup()
    // Или убедитесь, что computed свойство `isAuthenticated` добавлено в `setup()`
    // или как свойство класса, если вы используете Options API без setup()
    // computed: {
    //     isAuthenticated() {
    //         // Этот код будет работать, если компонент еще не переведен на Composition API полностью
    //         return !!this.$page.props.auth.user;
    //     }
    // }
}
</script>

<style scoped>
/* Ваши существующие стили */
.main-section {
    color: white;
    font-family: "Montserrat";
    width: 100%;
    min-height: 100vh;
    padding: 20px;
    box-sizing: border-box;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 50px;
}

.product-detail-container {
    max-width: 1200px;
    width: 100%;
    background-color: #2c2c2c;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.product-card-detail {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    justify-content: center;
}

.image-gallery {
    flex: 1;
    min-width: 300px;
    max-width: 500px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.main-product-image {
    width: 100%;
    height: auto;
    max-height: 400px;
    object-fit: contain;
    border-radius: 8px;
    margin-bottom: 15px;
    border: 1px solid #444;
}

.thumbnail-row {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding-bottom: 5px;
}

.thumbnail {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.2s ease;
}

.thumbnail:hover {
    border-color: #ffd700;
}

.active-thumbnail {
    border-color: #ffd700;
    box-shadow: 0 0 5px rgba(255, 215, 0, 0.5);
}

.product-info {
    flex: 2;
    min-width: 300px;
    padding-left: 20px;
    border-left: 1px dashed #555;
}

.title-detail {
    font-size: 36px;
    margin-bottom: 15px;
    color: #ffd700;
}

.description {
    font-size: 18px;
    line-height: 1.6;
    margin-bottom: 25px;
    color: #e0e0e0;
}

.price-detail {
    font-size: 30px;
    font-weight: bold;
    color: #ffd700;
    margin-bottom: 30px;
}

.add-to-cart-section {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-top: 30px;
}

.quantity-selector {
    width: 80px;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #555;
    background-color: #444;
    color: white;
    font-size: 18px;
    text-align: center;
}

.add-to-cart-button {
    background-color: #884535;
    color: white;
    padding: 15px 30px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.add-to-cart-button:hover {
    background-color: #a05e4a;
}

.add-to-cart-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.loading-message {
    text-align: center;
    font-size: 24px;
    color: #ccc;
    padding: 50px;
}

/* Новые стили для сообщения об авторизации */
.auth-message {
    font-size: 18px;
    color: #ccc;
    text-align: center; /* Центрируем, если это на отдельной строке */
    width: 100%; /* Занимаем всю доступную ширину */
    margin: 20px 0;
}

.login-prompt-link, .register-prompt-link {
    color: #ffd700; /* Золотистый цвет для ссылок */
    text-decoration: underline;
    font-weight: bold;
    transition: color 0.2s ease;
}

.login-prompt-link:hover, .register-prompt-link:hover {
    color: #ffb700;
}


/* Адаптация для мобильных устройств */
@media (max-width: 900px) {
    .product-card-detail {
        flex-direction: column;
        align-items: center;
    }

    .image-gallery, .product-info {
        min-width: unset;
        width: 100%;
        padding-left: 0;
        border-left: none;
    }

    .product-info {
        text-align: center;
        padding-top: 30px;
        border-top: 1px dashed #555;
    }

    .title-detail {
        font-size: 28px;
    }

    .price-detail {
        font-size: 24px;
    }
}

@media (max-width: 600px) {
    .product-detail-container {
        padding: 20px;
    }
}
@media (max-width: 600px) {
    .add-to-cart-section {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }

    .quantity-selector {
        width: 100%;
        max-width: 150px;
        margin: 0 auto;
    }

    .add-to-cart-button {
        width: 100%;
        padding: 12px 20px;
    }
    .auth-message {
        font-size: 16px;
    }
}
</style>