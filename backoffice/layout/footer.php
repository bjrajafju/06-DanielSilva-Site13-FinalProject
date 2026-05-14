</div> <!-- End of #content -->
</div> <!-- End of #wrapper -->

<!-- jQuery and Bootstrap 4.5.3 JS Bundle -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom Scripts -->
<script>
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (!confirm('Tem a certeza que deseja eliminar este item?')) {
                e.preventDefault();
            }
        });
    });
</script>
</body>

</html>

