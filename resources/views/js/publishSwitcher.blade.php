<script>
    $('.publish').on('click', function(){
        let url = $(this).attr('url');
        let data = {
            _token: '{{ csrf_token() }}',
            switch: $(this).attr('switch'),
            item: $(this).attr('item'),
            line: $(this).attr('line')
        }

        $.post(url, data)
        .done(function(response){
            if(response.result){
                toastr.success(response.message + '. Recargando pagina...');
            } else {
                toastr.error(response.message + '. Recargando pagina...');
            }
            setTimeout(() => {
                location.reload();
            }, 2000)
        })
    })
</script>
