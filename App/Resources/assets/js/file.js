$(document).ready(function () {
    $('.upload--file-btn').on('click', function (e) {
        const $wrapper = $(this).closest('.file-wrapper');
        $wrapper.find('input').click();
    });
    $('.file-wrapper input').on('change', function () {
        const $wrapper = $(this).closest('.file-wrapper');
        let reader = new FileReader();
        reader.onload = function(){
            var $preview = $wrapper.find('.file--preview');
            $preview.html('');
            $preview.append("<img src=" + reader.result + ">");
        };
        reader.readAsDataURL(event.target.files[0]);
    });
    $('.file--remove').on('click', function () {
       const $wrapper = $(this).closest('.file-wrapper');
       $wrapper.remove();
    });
});
