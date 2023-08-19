<template>
    <div class="container">
        <div class="card shadow-sm mt-5">
            <div class="card-header text-center">
                <h4>Edit Product</h4>
            </div>
            <div class="card-body">                
                <form @submit.prevent="changeProduct($route.params.id)" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <input v-model="product.name" type="text" name="name" :class="{'is-invalid text-danger': errors.name}" class="form-control" placeholder="Product Name">
                            <span v-if="errors.name" class="text-danger fw-bold">
                                {{ errors.name[0] }}
                            </span>
                        </div>
                        <div class="col-6 mb-3">
                            <input v-model="product.price" type="text" name="price" :class="{'is-invalid text-danger': errors.price}" class="form-control" placeholder="Unit Price">
                            <span v-if="errors.price" class="text-danger fw-bold">
                                {{ errors.price[0] }}
                            </span>
                        </div>
                        <div class="col-12 mb-3">
                            <input type="file" name="image" :class="{'is-invalid': errors.image}" class="form-control" @change="onFileChange" accept="image/png, image/jpeg, image/jpg">
                            <div v-if="imagePath !== null">
                                Current image:
                                <img :src="imagePath" alt="Product Image" width="100" height="100">
                            </div>
                            <div v-else></div>
                            <span v-if="errors.image" class="text-danger fw-bold">
                                {{ errors.image[0] }}
                            </span>
                        </div>
                        <div class="col-12 mb-3">
                            <textarea v-model="product.description" name="description" id="" cols="30" rows="7" :class="{'is-invalid text-danger': errors.description}" class="form-control" placeholder="Description"></textarea>
                            <span v-if="errors.description" class="text-danger fw-bold">
                                {{ errors.description[0] }}
                            </span>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-success me-3" :disabled="isLoading">
                                Update <Spinner v-if="isLoading" />
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
    import { onMounted, defineProps } from 'vue'
    import { RouterLink } from 'vue-router';
    import useProducts from '../../composables/products'
    import Spinner from '../../components/Spinner.vue'

    const { 
        errors,
        isLoading,
        product,
        imagePath,
        handleFileChange,
        getProduct,
        updateProduct
    } = useProducts()
    
    const onFileChange = async (event) => {
      await handleFileChange(event)
    }
    
    const changeProduct = async (id) => {                
        await updateProduct(id)
    }
    
    const props = defineProps({
        id: {
            required: true,
            type: String
        }
    })
    
    onMounted(() => getProduct(props.id))
</script>