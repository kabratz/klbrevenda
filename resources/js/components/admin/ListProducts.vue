<style>
    .table {
        border: solid 1px grey;
        border-radius: 16px;
        padding: 8px;
    }

    .table-header {
        font-weight: bold;
        background-color: #ccc;
        border-radius: 8px 8px 0 0;
        padding: 8px 8px 0 8px;
    }

    .product-box {
        border-bottom: solid 1px grey;
    }

    .line {
        display: flex;
        padding: 4px;
        align-items: center;
        cursor: pointer;
    }

    .column {
        width: 25%;
    }

    .options-column {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    button {
        background-color: inherit;
        border: solid 1px grey;
        border-radius: 16px;
        padding: 4px;
    }

    .button-close-modal {
        border: none;
        font-size: 24px;
        cursor: pointer;
    }

    .details {
        padding: 8px;
        background-color: #f9f9f9;
        border-top: solid 1px #eee;
        display: none;
    }

    .details.active {
        display: block;
    }

    .rotate {
        transition: transform 0.3s ease;
    }

    .rotate.active {
        transform: rotate(-90deg);
    }

    .modal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 16px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        display: none;
        min-width: 80vw;
    }

    .modal.active {
        display: block;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    }

    .modal-overlay.active {
        display: block;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: solid 1px grey;
        margin-bottom: 16px;
    }

    .modal-header h4 {
        margin: 0;
    }

    .modal-body {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .image-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .image-modal {
        max-width: 90%;
        max-height: 90%;
    }

    .image-modal img {
        max-width: 90vw;
        max-height: 90vh;
    }

    .no-scroll {
        overflow: hidden;
    }

    .modal-content {
        max-height: 80vh;
        overflow-y: auto;
    }
</style>
<template>
    <nav class="navbar">
        <h1 class="navbar-title">KLB Revenda</h1>
        <div class="navbar-content">
        <p v-if="isLoggedIn" class="welcome-message">
            Welcome back, {{ username }}!
            <button @click="handleLogout" class="logout-button">Logout</button>
        </p>
        <p v-else class="login-message">Please log in to access your account.</p>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">Products</div>
                <button @click="openCreateModal">Add New Product</button>

                <div class="card-body">
                    <div class="table">
                        <div class="table-header">
                            <div class="line">
                                <div class="column">Name</div>
                                <div class="column">Quantity</div>
                                <div class="column">Brand</div>
                                <div class="column">Options</div>
                            </div>
                        </div>
                        <div class="body">
                            <div v-for="product in localProducts.products" :key="product.id">
                                <div class="line" @click="toggleDetails(product.id)">
                                    <div class="column">{{ product.name }}</div>
                                    <div class="column">{{ product.quantity }}</div>
                                    <div class="column">{{ product.brand.name }}</div>
                                    <div class="column options-column">
                                        <button @click.stop="openEditModal(product)">Edit</button>
                                        <button @click.stop="deleteProduct(product.id)">Delete</button>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 320 512"
                                            :class="{ rotate: true, active: isActive(product.id) }">
                                            <path
                                                d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="details" :class="{ active: isActive(product.id) }">
                                    <p><strong>Description:</strong> {{ product.description }}</p>
                                    <p><strong>Price:</strong> R${{ product.price }}</p>
                                    <p><strong>Gender:</strong> {{ product.gender }}</p>
                                    <p><strong>Google Category:</strong> {{ product.google_product_category }}</p>
                                    <p><strong>Facebook Category:</strong> {{ product.fb_product_category }}</p>
                                    <p><strong>SKU:</strong> {{ product.sku }}</p>
                                    <div v-if="product.categories.length">
                                        <h4>Categories:</h4>
                                        <ul>
                                            <li v-for="category in product.categories" :key="category.id">
                                                {{ category.name }}
                                                <ul v-if="category.parent">
                                                    <li v-for="parent in getParentCategories(category)"
                                                        :key="parent.id">
                                                        {{ parent.name }}
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="images-section">
                                        <p><strong>Images:</strong></p>
                                        <div v-for="(image, index) in product.images" :key="image.id"
                                            class="image-item">
                                            <img :src="`/storage/${image.file}`" alt="Product Image"
                                                @click="openImageModal(image.file)"
                                                style="cursor: pointer; width: 100px; height: 100px;">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal e Overlay -->
        <div class="modal-overlay" :class="{ active: isModalActive }" @click="closeModal"></div>
        <div v-if="isImageModalActive" class="image-modal-overlay" @click="closeImageModal">
            <div class="image-modal">
                <img :src="`/storage/${currentImage}`" alt="Full-size Image">
            </div>
        </div>
        <div class="modal" :class="{ active: isModalActive }">
            <div class="modal-header">
                <h4>{{ isEditing ? 'Edit Product' : 'Create Product' }}</h4>
                <button class="button-close-modal" @click="closeModal">&times;</button>
            </div>
            <div class="modal-content">
                <form @submit.prevent="saveProduct" class="modal-body">
                    <label>Name</label>
                    <input v-model="editableProduct.name" type="text" />

                    <label>Description</label>
                    <!-- <textarea v-model="editableProduct.description"></textarea> -->
                    <div ref="quillEditor"></div> <!-- Editor Quill -->


                    <label>Price</label>
                    <input v-model="editableProduct.price" type="number" step="0.01" />

                    <label>Quantity</label>
                    <input v-model="editableProduct.quantity" type="number" />

                    <label>Google Category</label>
                    <input v-model="editableProduct.google_product_category" type="text" />

                    <label>Facebook Category</label>
                    <input v-model="editableProduct.fb_product_category" type="text" />

                    <label>SKU</label>
                    <input v-model="editableProduct.sku" type="text" />


                    <!-- Select de Gênero -->
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select v-model="editableProduct.gender" id="gender" class="form-control">
                            <option disabled value="">Select gender</option>
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                            <option value="unisex">Unisex</option>
                        </select>
                    </div>

                    <!-- Select de Marcas -->
                    <div class="form-group">
                        <label for="brand">Brand:</label>
                        <select v-model="editableProduct.brand_id" id="brand" class="form-control">
                            <option disabled value="">Select brand</option>
                            <option v-for="brand in this.localProducts.brands" :key="brand.id" :value="brand.id">
                                {{ brand.name }}
                            </option>
                        </select>
                    </div>

                    <div class="images-section">
                        <p><strong>Images:</strong></p>
                        <div v-for="(image, index) in editableProduct.images" :key="index" class="image-item">
                            <input type="file" @change="uploadImage($event, editableProduct.id, index)" />
                            <img :src="`/storage/${image.file}`" alt="Product Image" @click="openImageModal(image.file)"
                                style="cursor: pointer; width: 40px; height: 40px;">

                            <input v-model="imageUrls[index]" placeholder="Or enter image URL" />
                            <button @click="updateImageUrl(image.id, index)">Update URL</button>
                            <button @click="removeImage(index)">Remove Image</button>
                        </div>
                        <button type="button" @click="addImageField()">Add New Image</button>
                    </div>

                    <button type="submit">{{ isEditing ? 'Save Changes' : 'Create Product' }}</button>
                </form>
            </div>
        </div>
        <div v-if="isImageModalActive" class="image-modal-overlay" @click="closeImageModal">
            <div class="image-modal">
                <img :src="`/storage/${currentImage}`" alt="Full-size Image">
            </div>
        </div>
    </div>
</template>

<script>
    import Quill from 'quill';
    import 'quill/dist/quill.snow.css'; // Importa o estilo do Quill
    import store from '../../../src/store.js';
    import { useRouter } from 'vue-router';
    
    export default {
        computed: {
        isLoggedIn() {
            return store.state.isLoggedIn;
        },
        username() {
            return store.state.username;
            }
        },
        data() {
            return {
                localProducts: { products: [], brands: [] },
                activeProductId: null,
                isModalActive: false,
                editableProduct: {
                    images: []
                },
                imageUrls: [],
                isEditing: false,
                isImageModalActive: false,
                currentImage: '',
                quill: null
            };
        },
        created() {
            this.fetchProducts();
            if(!store.state.isLoggedIn){
                const router = useRouter()
                router.push('/login');
            }
        },
        setup() {
            const router = useRouter(); // Use the router instance
            
            const handleLogout = () => {
                store.logout(); // Chama a mutação para deslogar
                router.push('/login'); // Redireciona para a rota /login
            };

            return {
                handleLogout,
            };
        },
        methods: {  
            async fetchProducts() {
                try {
                    // Substitua '/api/products' pelo endpoint correto da sua API
                    const response = await axios.get('/api/products');
                    this.localProducts = response.data;
                } catch (error) {
                    console.error('Erro ao buscar produtos:', error);
                }
            },
            toggleDetails(productId) {
                this.activeProductId = this.activeProductId === productId ? null : productId;
            },
            isActive(productId) {
                return this.activeProductId === productId;
            },
            openEditModal(product) {
                this.isEditing = true;
                this.editableProduct = { ...product, brand_id: product.brand.id, images: product.images || [] };
                this.imageUrls = this.editableProduct.images.map(img => img.file || ''); // Carrega as URLs existentes
                this.isModalActive = true;
                this.$nextTick(() => {
                    if (this.quill) {
                        this.quill.root.innerHTML = this.editableProduct.description;
                    }
                });
                document.body.classList.add('no-scroll');

            },
            openCreateModal() {
                this.isEditing = false;
                this.editableProduct = {
                    name: '',
                    description: '',
                    price: 0,
                    quantity: 0,
                    google_product_category: '',
                    fb_product_category: '',
                    gender: '',
                    brand_id: '',
                    images: []
                };
                this.imageUrls = []; // Limpa as URLs de imagens
                this.isModalActive = true;
                document.body.classList.add('no-scroll');
            },
            closeModal() {
                this.isModalActive = false;
                this.editableProduct = {};
                document.body.classList.remove('no-scroll');
            },
            saveProduct() {
                const url = this.isEditing ? `/products/${this.editableProduct.id}` : '/products';
                const method = this.isEditing ? 'PUT' : 'POST';

                fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(this.editableProduct)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (this.isEditing) {
                                this.localProducts = this.localProducts.map(product =>
                                    product.id === this.editableProduct.id ? data.product : product
                                );
                            } else {
                                this.localProducts.push(data.product);
                            }
                            this.closeModal();
                        } else {
                            console.error('Failed to save product:', data);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            },
            deleteProduct(productId) {
                if (confirm('Are you sure you want to delete this product?')) {
                    fetch(`/products/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => {
                            if (response.ok) {
                                this.localProducts = this.localProducts.filter(product => product.id !== productId);
                                console.log('Product deleted:', productId);
                            } else {
                                console.error('Failed to delete product');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            },
            addImageField() {
                this.editableProduct.images.push({ url: '', file: null });
            },
            removeImageField(index) {
                this.editableProduct.images.splice(index, 1);
            },
            handleImageUpload(event, index) {
                const file = event.target.files[0];
                this.editableProduct.images[index].file = file;
            },
            getImageSrc(imagePath) {
                return '/storage/' + imagePath;
            },
            openImageModal(imagePath) {
                this.currentImage = imagePath;
                this.isImageModalActive = true;
            },
            closeImageModal() {
                this.isImageModalActive = false;
                this.currentImage = '';
            },
            getParentCategories(category) {
                let parents = [];
                let current = category.parent;
                while (current) {
                    parents.push(current);
                    current = current.parent;
                }
                return parents;
            }
        },
        mounted() {
            this.quill = new Quill(this.$refs.quillEditor, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': '1' }, { 'header': '2' }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['link']
                    ]
                }
            });
        }
    };

</script>