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
                            'product_id',
                            $products ?? [],
                            !isset($client) ? null : optional($client->order)->product_id ?? null,
                            ['class' => 'form-control'],
                        ) !!}
                    </div>
                    <div class="col">
                        {!! Form::select(
                            'service_frequency',
                            $serviceFrequencies ?? [],
                            !isset($client) ? null : optional($client->order)->service_frequency,
                            ['class' => 'form-control'],
                        ) !!}
                    </div>
                    <div class="col">
                        {!! Form::select('zone_id', $zones ?? [], !isset($client) ? null : $client->zone_id, [
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
                        <th>Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients ?? [] as $key => $client)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $client->name ?? '' }}</td>
                            <td>
                                <input type="checkbox" name="order_details" @click="createOrderDetail($event)"
                                    value="{{ $client->id }}"> @{{ title }}
                                <input type="checkbox" name="order_details" @click="createOrderDetail($event)"
                                    value="{{ $client->id }}"> @{{ title }}
                                <input type="checkbox" name="order_details" @click="createOrderDetail($event)"
                                    value="{{ $client->id }}"> @{{ title }}>
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
                    title: 'Sample'
                }
            },
            methods: {
                createOrderDetail(event) {
                    ulr = '{{ route('order-details.store') }}';
                    postData = {
                        client_id: event.target.value,
                        product_id: document.querySelector('select[name="product_id"]').value,
                        service_frequency: document.querySelector('select[name="service_frequency"]').value,
                        zone_id: document.querySelector('select[name="zone_id"]').value,
                    };

                    axios.post(
                            url,
                            postData
                        )
                        .then(
                            reponse => {
                                console.log(response.data);
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
