<div id="productList">
    <!-- Filtered product list will be displayed here -->
    <table class="w-full table-auto">
        <thead>
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td class="border px-4 py-2">{{ $product->name }}</td>
                <td class="border px-4 py-2">{{ $product->description }}</td>
                <td class="border px-4 py-2">৳{{ number_format($product->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    $(document).ready(function () {
        $('#filterButton').click(function () {
            filterProducts();
        });

        $('#search').on('input', function () {
            filterProducts();
        });

        function filterProducts() {
            var keyword = $('#search').val();

            // Set the CSRF token in the headers
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('products.search') }}', 
                data: {
                    "keyword": keyword
                },
                success: function (response) {
                    
                    $('#productList').html(response);
                }
            });
        }
    });
</script>
