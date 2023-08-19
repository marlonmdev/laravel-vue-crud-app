import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router';
import debounce from 'lodash.debounce'

export default function useProducts() {
    const router = useRouter()
    const products = ref([])
    const product = ref([])
    const errors = ref({})
    const selectedFile = ref(null)
    const isLoading = ref(false)
    const searchInput = ref('')
    const imagePath = ref(null)
    
    const getProducts = async (page = 1) => {        
        try {
            const response = await axios.get(`/api/products?page=${page}&search=${searchInput.value}`);
            products.value = response.data.data;
        } catch (error) {
            console.log(error);
        }
    }
    
    const getProduct = async (id) => {
        await axios
        .get(`api/products/${id}/edit`)
        .then(response => {
            product.value = response.data
            
            if(response.data.image !== null){
                imagePath.value = `${axios.defaults.baseURL}storage/${response.data.image}`
            }   
        })
        .catch(error => console.log(error))
    }
    
    const performSearch = debounce(async() => {
        await getProducts()
    }, 500)
    
    const handleFileChange = (event) => {
        selectedFile.value = event.target.files[0]
    }
    
    const storeProduct = async (formData) => {
        errors.value = ''
        isLoading.value = true
        
        await axios
        .post(`api/products`, formData)
        .then(async(response) => { 
            alert(response.data.message)
            await router.push({name:'products.index'})
        })
        .catch(error => {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else if(error.request) {
                console.log(error.request);
            }else{
                console.log('Error:', error.message);
            }
        })
        .finally(() => isLoading.value = false)
    }
    
    const updateProduct = async (id) => {     
        errors.value = ''
        isLoading.value = true    
        
        const formData = new FormData()
        formData.append('name', product.value.name)
        formData.append('price', product.value.price)
        formData.append('image', selectedFile.value)
        formData.append('description', product.value.description)
        formData.append("_method", "put");
                        
        try {
            const response = await axios.post(`api/products/${id}`, formData);
            alert(response.data.message);
            await router.push({ name: 'products.index' });
        } catch (error) {
            if (error.response) {
                if (error.response.status === 422) {
                    errors.value = error.response.data.errors;
                } else {
                    console.log('Error response:', error.response.data);
                }
            } else if (error.request) {
                console.log('Request error:', error.request);
            } else {
                console.log('Error:', error.message);
            }
        } finally {
            isLoading.value = false;
        }
    }
    
    const destroyProduct = async (id) => {
        await axios
        .delete(`api/products/${id}`)
        .then(response => alert(response.data.message))
        .catch(error => console.log(error))
        await getProducts()
    }
    
    return {
        errors,
        product,
        products,
        selectedFile,
        imagePath,
        isLoading, 
        searchInput,
        handleFileChange,
        getProducts,
        getProduct,
        storeProduct,
        updateProduct,
        destroyProduct,
        performSearch
    }
}