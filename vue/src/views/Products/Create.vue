<template>
    <div class="container">
        <div class="card shadow-sm mt-5">
            <div class="card-header text-center">
                <h4>Add New Product</h4>
            </div>
            <div class="card-body">               
                <form @submit.prevent="saveProduct(form)" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <input v-model="form.name" type="text" name="product_name" :class="{'is-invalid text-danger': errors.name}" class="form-control" placeholder="Product Name">
                            <span v-if="errors.name" class="text-danger fw-bold">
                                {{ errors.name[0] }}
                            </span>
                        </div>
                       
                        <div class="col-6 mb-3">
                            <input v-model="form.price" type="text" name="price" :class="{'is-invalid text-danger': errors.price}" class="form-control" placeholder="Unit Price">
                            <span v-if="errors.price" class="text-danger fw-bold">
                                {{ errors.price[0] }}
                            </span>
                        </div>
                       
                        <div class="col-12 mb-3">
                            <input type="file" name="image" :class="{'is-invalid': errors.image}" class="form-control" @change="handleFileChange" accept="image/png, image/jpeg, image/jpg">
                            <span v-if="errors.image" class="text-danger fw-bold">
                                {{ errors.image[0] }}
                            </span>
                        </div>
                        <div class="col-12 mb-3">
                            <textarea  v-model="form.description" name="description" cols="30" rows="7" :class="{'is-invalid text-danger': errors.description}" class="form-control" placeholder="Description"></textarea>
                            <span v-if="errors.description" class="text-danger fw-bold">
                                {{ errors.description[0] }}
                            </span>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-3" :disabled="isLoading">
                                Create <Spinner v-if="isLoading" />                               
                            </button>
                            
                            <RouterLink :to="{name:'products.index'}" class="btn btn-dark">Go Back</RouterLink>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { reactive } from 'vue'
    import { RouterLink } from 'vue-router';
    import useProducts from '../../composables/products'
    import Spinner from '../../components/Spinner.vue'

    const { errors, isLoading, selectedFile, handleFileChange, storeProduct } = useProducts()

    const form = reactive({
        name: '',
        price: '',
        description: ''    
    })
    
    const saveProduct = async (form) => {
        const formData = new FormData
        
        formData.append('name', form.name)
        formData.append('price', form.price)
        formData.append('image', selectedFile.value)
        formData.append('description', form.description)
        
        await storeProduct(formData)
    }

</script>
