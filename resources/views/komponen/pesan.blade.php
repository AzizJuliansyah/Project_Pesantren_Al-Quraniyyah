@if (session('error'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        })

        ;(async () => {
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}",
            })
        })()
    </script>
@elseif (session('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 2800,
            timerProgressBar: true,
        })

        ;(async () => {
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}",
            })
        })()
    </script>
@endif
