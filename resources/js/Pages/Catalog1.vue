<template>
    <section class="main-section">
        <div class="catalog">КАТАЛОГ</div>
        <div class="content-wrapper">
            <div class="products-grid">
                <Link v-for="product in filteredProducts" :key="product.id" :href="`/products/${product.id}`"
                    class="product-card">
                <div class="image-container">
                    <img class="product-image" :src="`/images/${product.image}`">
                </div>
                <div class="product-info">
                    <div class="title">{{ product.name }}</div>
                    <div class="price">{{ product.price }}р</div>
                </div>
                </Link>
            </div>
            <div class="filter-container">
                <div class="filter">
                    <h3 class="filter-title">Категории</h3>
                    <input type="checkbox" v-model="filters.kurs" id="check-kurs" />
                    <label for="check-kurs">Курсы</label>
                    <br>
                    <input type="checkbox" v-model="filters.books" id="check-books" />
                    <label for="check-books">Книги</label>
                    <br>
                    <input type="checkbox" v-model="filters.shabl" id="check-shabl" />
                    <label for="check-shabl">Шаблоны</label>

                    <h3 class="filter-title">Цена</h3>
                    <div class="price-filter">
                        <div class="price-input">
                            <label for="min-price">От</label>
                            <input type="number" id="min-price" v-model.number="priceRange.min" placeholder="0" min="0"
                                class="price-field">
                        </div>
                        <div class="price-input">
                            <label for="max-price">До</label>
                            <input type="number" id="max-price" v-model.number="priceRange.max" placeholder="0" min="0"
                                class="price-field">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        Link,
    },
    props: {
        products: {
            type: Array,
            required: true,
            default: () => [],
            validator: (value) => Array.isArray(value)
        }
    },
    data() {
        return {
            filters: {
                kurs: true,
                books: true,
                shabl: true
            },
            priceRange: {
                min: null,
                max: null
            }
        }
    },
    computed: {
        filteredProducts() {
            if (!this.products || !Array.isArray(this.products)) return [];

            return this.products.filter(product => {
                // Проверка категории
                const categoryMatch =
                    (this.filters.kurs && product.category === 'kurs') ||
                    (this.filters.books && product.category === 'books') ||
                    (this.filters.shabl && product.category === 'shabl');

                // Проверка цены
                let priceMatch = true;
                if (this.priceRange.min !== null && product.price < this.priceRange.min) {
                    priceMatch = false;
                }
                if (this.priceRange.max !== null && product.price > this.priceRange.max) {
                    priceMatch = false;
                }

                return categoryMatch && priceMatch;
            });
        }
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
}

.catalog {
    font-size: 32px;
    margin-top: 50px;
    text-align: center;
    margin-bottom: 40px;
}

.content-wrapper {
    display: flex;
    max-width: 1400px;
    margin: 0 auto;
    gap: 40px;
}

.filter-container {
    width: 250px;
    position: sticky;
    top: 20px;
    height: fit-content;
}

.filter {
    padding: 20px;
    border: dashed 2px white;
    border-radius: 8px;
    font-size: 18px;
}

.filter input[type="checkbox"] {
    margin-right: 10px;
    accent-color: #884535;
    width: 18px;
    height: 18px;
}

.products-grid {
    flex: 1;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
    align-content: start;
}

.product-card {
    border: dashed 2px white;
    border-radius: 8px;
    padding: 15px;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    cursor: pointer;
    text-decoration: none;
    color: inherit;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.image-container {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    min-height: 200px;
}

.product-image {
    max-width: 100%;
    max-height: 250px;
    width: auto;
    height: auto;
    border-radius: 5px;
    object-fit: contain;
}

.product-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 10px;
}

.title {
    font-size: 18px;
    margin-bottom: 8px;
    text-align: center;
    word-break: break-word;
    width: 100%;
}

.price {
    font-size: 20px;
    font-weight: bold;
    color: #ffd700;
    text-align: center;
    margin-top: auto;
}

.filter {
    padding: 20px;
    border: dashed 2px white;
    border-radius: 8px;
    font-size: 18px;
    width: 100%;
    box-sizing: border-box;
}

.price-filter {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
}

.price-input {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
}

.price-input label {
    width: 30px;
    flex-shrink: 0;
}

.price-field {
    width: 100%;
    max-width: calc(100% - 40px);
    padding: 8px;
    border-radius: 4px;
    background-color: #884535;
    color: white;
    font-family: "Montserrat";
    box-sizing: border-box;
    border: dashed 2px white;
}

.price-field:focus {
    outline: none;
    border-color: #ffd700;
}

@media (max-width: 1200px) {
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    }
}

@media (max-width: 900px) {
    .content-wrapper {
        flex-direction: column;
    }

    .filter-container {
        position: static;
        width: 100%;
        margin-bottom: 30px;
    }

    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
}

@media (max-width: 600px) {
    .products-grid {
        grid-template-columns: 1fr;
    }

    .product-card {
        flex-direction: row;
        align-items: center;
        gap: 15px;
    }

    .image-container {
        min-height: auto;
        margin-bottom: 0;
        flex: 0 0 120px;
    }

    .product-info {
        align-items: flex-start;
        text-align: left;
    }

    .title,
    .price {
        text-align: left;
    }

    @media (max-width: 600px) {
        .price-filter {
            flex-direction: row;
            flex-wrap: wrap;
        }

        .price-input {
            flex: 1 1 calc(50% - 5px);
            /* 50% ширины минус половина gap */
            min-width: 0;
            /* Разрешаем сжатие */
        }

        .price-field {
            max-width: none;
        }
    }
}
</style>