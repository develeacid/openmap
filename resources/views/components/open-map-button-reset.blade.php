{{-- 
Este es el componente de botón para restablecer el mapa. 
Este botón permite que el mapa se vuelva a cargar con los parámetros iniciales (por ejemplo, la capa de "Regiones" de Oaxaca) y restablezca la vista a su estado predeterminado.
--}}
<div class="d-flex justify-content-center mt-3"> {{---- Contenedor flexbox que alinea el botón al centro y aplica un margen superior de 3 unidades. --}}
    {{---- Botón que ejecuta la función JavaScript 'resetMapLayer()' cuando se hace clic en él. --}}
    <button class="btn btn-primary" onclick="resetMapLayer();">
        Restablecer a Oaxaca {{---- Texto del botón que indica la acción de restablecer el mapa. --}}
    </button>
</div>