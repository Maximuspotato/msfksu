<script>
    //window.open('{{ $url }}');
    url = '{{ $url }}';
    str = url.replace(/&amp;/g,'&');
    window.location.href = str;
</script>