{{-- secondary
primary
success
warning
alert
info --}}
@if(Session::has('title'))
<script type="text/javascript">
swal({
    title: '{{ Session::get('title') }}',
    text: '{{ Session::get('text') }}',
    type: '{{ Session::get('type') }}',
    confirmButtonText: 'הבנתי, תודה',
    @if(Session::has('timer'))
        timer: 3000,
        //showCloseButton: true,
    @endif
});
</script>
@endif
