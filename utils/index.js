const currentPath = window.location.pathname;
const navLinks = document.querySelectorAll('.nav-items');
console.log(currentPath);
navLinks.forEach(link => {
    const linkPath = new URL(link.href).pathname;
    console.log(linkPath);
    console.log(linkPath === currentPath);
    if (linkPath === currentPath) {
        link.classList.add('active');
    }
});

//function formatDateTime(dateString) {
//    const options = {
//        year: 'numeric',
//        month: 'long',
//        day: 'numeric',
//        hour: '2-digit',
//        minute: '2-digit'
//    };
//    return new Date(dateString).toLocaleDateString(undefined, options);
//}
//
//export { formatDateTime };