<template>
    <div class="container">    
        <div class="card shadow-sm mt-5">
            <div class="px-4 py-2 d-flex justify-content-between align-items-center">
                <RouterLink :to="{name:'products.create'}" class="btn btn-primary"><i class="bi bi-plus-lg fs-6"></i> Add</RouterLink>
                <form action="#">
                    <div class="input-group">
                        
                        <input v-model="searchInput" type="text" class="shadow-sm form-control" @input="searchProducts" placeholder="Search...">
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-striped table-responsive">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Created On</th>
                        <th></th>
                    </thead>
                    <tbody v-if="products.length > 0">
                        <tr v-for="(product, index) in products" :key="index">
                            <td>{{ product.id }}</td>
                            <td>{{ product.name }}</td>
                            <td>&#8369; {{ product.price }}</td>
                            <td>{{ product.description }}</td>
                            <td>{{ product.created_at }}</td>
                            <td>
                                <RouterLink :to="{name:'products.edit', params:{ id: product.id }}" class="btn btn-success me-2">
                                    <i class="bi bi-pencil fs-6"></i>
                                </RouterLink>
                                <button @click="deleteProduct(product.id)"  class="btn btn-danger">
                                    <i class="bi bi-trash fs-6"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td class="text-center fw-bold fs-5" colspan="5">
                                <em>No data found</em>
                            </td>
                        </tr>
                    </tbody>                    
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { onMounted } from 'vue'
    import { RouterLink } from 'vue-router'
    import useProducts from '../../composables/products'

    const { 
        products,
        getProducts,
        destroyProduct,
        searchInput,
        performSearch,
    } = useProducts()    

    const searchProducts = async () => {
        await performSearch()
    }
    
    const deleteProduct = async (id) => {
        if(!window.confirm('Are you sure?')){return}
        await destroyProduct(id)
    }
    
    const getResults = async () => {
        await getProducts()
    }
    
    onMounted(() => getProducts())    
</script>