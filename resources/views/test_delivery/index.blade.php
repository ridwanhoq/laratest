<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script src="https://unpkg.com/vue@next"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>

<body>

    <div class="card" id="orderDetailsTable">
        <div class="card-header">
            <form action="" method="post">
                <div class="row">
                    <div class="col">
                        {!! Form::select(
                            'service_frequency',
                            $serviceFrequencies ?? [],
                            !isset($order) ? null : $order->service_frequency,
                            ['class' => 'form-control'],
                        ) !!}
                    </div>
                    <div class="col">
                        {!! Form::select('zone_id', $zones ?? [], !isset($order) ? null : optional($order->client)->zone_id, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="col">
                        {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <table id="">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Client</th>
                        <th>Products</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders ?? [] as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ optional($order->client)->name ?? '' }}</td>
                            <td>
                                @foreach ($order->lastOrderDetails ?? [] as $orderDetail)
                                <input type="checkbox" name="order_details" @click="createOrderDetail($event)"
                                    value="{{ $orderDetail->id }}"> {{ $orderDetail->id }} {{ optional($orderDetail->product)->name ?? '' }}                                 
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {!! $clients->links() !!} --}}
        </div>
    </div>

    <script>
        const app = Vue.createApp({
            data() {
                return {
                    isOrderDetailChecked: false
                }
            },
            methods: {
                createOrderDetail(event) {
                    url = "{{ route('createOrderDetail.store') }}";
                    postData = {
                        orderDetailId: event.target.value,
                        isOrderDetailChecked: event.target.checked,
                    };

                    axios.post(
                            url,
                            postData
                        )
                        .then(
                            response => {
                                if(response.data){
                                    console.log('<' + response.data + '>');
                                }
                            }
                        )
                        .catch(
                            error => {
                                console.log(error);
                            }
                        );

                }
            },
        });

        app.mount('#orderDetailsTable');
    </script>

</body>

</html>
