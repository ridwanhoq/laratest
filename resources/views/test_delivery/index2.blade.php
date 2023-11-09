<script src="https://unpkg.com/vue@next"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <div id="orderDetailsTable">
        <input type="checkbox" v-model="isChecked" :value="order_id">
    </div>
<script>
    const app = Vue.createApp({
        data() {
            return {
                isChecked: false,
                order_id: 1 // Replace with your actual order_id
            };
        },
        watch: {
            isChecked: function(newValue) {
                this.updateOrderQuantity(newValue ? this.order_id : null);
            }
        },
        methods: {
            updateOrderQuantity(orderId) {
                if (orderId) {
                    const quantity = this.isChecked ? 1 : 0;
                    const url = "{{ route('createOrderDetail.store') }}";

                    axios.post(url, {
                            order_id: orderId,
                            quantity: quantity
                        })
                        .then(response => {
                            // Handle success response if needed
                        })
                        .catch(error => {
                            // Handle error response if needed
                        });
                }
            }
        }
    });
    
    app.mount('#orderDetailsTable');
</script>
