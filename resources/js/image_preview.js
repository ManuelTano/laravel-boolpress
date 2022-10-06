const placeholder = "https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/681px-Placeholder_view_vector.svg.png"
const image = document.getElementById('image')
const preview = document.getElementById('preview')

image.addEventListener('input', () => {
    if (image.files && image.files[0]) {
        let reader = new FileReader();
        reader.readAsDataURL(image.files[0]);
        reader.addEventListener('load', event => {
            preview.src = event.target.result;
        });
    } else preview.src = placeholder;
           preview.setAttribute('src', placeholder);
})
