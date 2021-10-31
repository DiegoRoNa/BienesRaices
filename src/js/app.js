
//FUNCIONABILIDAD DEL MENU RESPONSIVE

//DOMContentLoaded - HTML, CSS y JS cargados
document.addEventListener('DOMContentLoaded', function(){
    eventListeners();

    darkMode();
});

//FUNCION DE DARK MODE
function darkMode(){

    //TOMA EL COLOR DEL SISTEMA OPERATIVO
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    //console.log(prefiereDarkMode.matches);
    
    if (prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    }else{
        document.body.classList.remove('dark-mode');
    }

    //SIN RECARGAR LA PAGINA, AL MOMENTO DE QUE EL USER CAMBIE EN SU SO EL TEMA, LA PAGINA LO HARÁ AL MISMO TIEMPO
    prefiereDarkMode.addEventListener('change', function(){
        if (prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        }else{
            document.body.classList.remove('dark-mode');
        }
    });

    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function(){
        document.body.classList.toggle('dark-mode');
    });
}

function eventListeners(){
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);//FUNCION AL DAR CLICK
}

function navegacionResponsive(){
    const navegacion = document.querySelector('.navegacion');

    //toggle, condiciona si existe la clase mostrar, si está la quita, si no, la coloca
    navegacion.classList.toggle('mostrar');
    
}