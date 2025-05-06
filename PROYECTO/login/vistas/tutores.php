<?php
require 'header.php';
?>
<span class="text">Tutores</span>
<div class="page-content">

    <div id="modal" class="modal">
        <button class="primary" onclick="window.dialog.showModal();" aria-label="Abrir formulario de nuevo tutor">
            Nuevo <span>+</span>
        </button>

        <dialog id="dialog" aria-labelledby="dialogTitle">
            <h2 id="dialogTitle">Registrar Tutor</h2>

            <form action="#" class="formulario" id="formulario">
                <!-- Grupo: Usuario -->
                <input type="hidden" id="id">

                <!-- Grupo: Cédula -->
                <div class="formulario__grupo" id="grupo__cedula">
                    <label for="cedula" class="formulario__label">Cédula <span class="obligatorio">*</span></label>

                    <div class="formulario__grupo-input formulario__grupo-cedula">
                        <div class="formulario__codigo-pais">
                            <select class="formulario__input formulario__codigo-select" id="nacionalidad" name="nacionalidad" required>
                                <!-- <option value="" disabled selected>Nac.</option> -->
                                <option value="V">V-</option>
                                <option value="E">E-</option>
                                <option value="P">P-</option>
                            </select>
                        </div>

                        <input type="text"
                            class="formulario__input formulario__cedula-input"
                            name="cedula"
                            id="cedula"
                            placeholder="Ej: 12345678"
                            pattern="[VEP]-\d{1,8}"
                            maxlength="9"
                            required>

                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>

                    <p class="formulario__input-error">Formato válido: X-12345678</p>
                </div>

                <!-- Grupo:  -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="" class="formulario__label">Primer Nombre <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese el nombre" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <!-- Grupo:  -->
                <div class="formulario__grupo" id="grupo__nombre">
                    <label for="" class="formulario__label">Segundo Nombre <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="nombre" placeholder="Ingrese el segundo nombre" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <div class="formulario__grupo" id="grupo__apellido">
                    <label for="" class="formulario__label">Primer Apellido <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="apellido" placeholder="Ingrese el primer apellido" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <div class="formulario__grupo" id="grupo__apellido">
                    <label for="" class="formulario__label">Segundo Apellido <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="text" class="formulario__input" name="" id="apellido" placeholder="Ingrese el segundo apellido" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error">Este campo solo debe contener letras</p>
                </div>

                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Sexo <span class="obligatorio">*</span></label>
                    <select id="sexo" aria-placeholder="sexo" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="">Masculino</option>
                        <option value="">Femenino</option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <!-- Contacto -->
                <div class="formulario__grupo" id="grupo__telefono">
                    <label for="telefono" class="formulario__label">Teléfono <span class="obligatorio">*</span></label>

                    <div class="formulario__grupo-input formulario__grupo-telefono">
                        <div class="formulario__codigo-pais">
                            <select class="formulario__input formulario__codigo-select">
                                <option value="" selected>0412</option>
                                <option value="">0414</option>
                                <option value="">0416</option>
                                <option value="">0426</option>
                                <option value="">0255</option>
                            </select>
                        </div>

                        <input type="tel" class="formulario__input formulario__telefono-input" name="telefono" id="telefono" placeholder="(555) 000-000" pattern="\(\d{3}\) \d{3}-\d{4}" required>
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>

                    <p class="formulario__input-error">Formato requerido: (XXX) XXX-XXXX</p>
                </div>

                <div class="formulario__grupo" id="grupo__correo">
                    <label for="telefono" class="formulario__label">Correo <span class="obligatorio">*</span></label>
                    <div class="formulario__grupo-input">
                        <input type="email" class="formulario__input" name="correo" id="e_mail" placeholder="Ingrese su correo electronico">
                        <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    </div>
                    <p class="formulario__input-error"></p>
                </div>

                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Condicion <span class="obligatorio">*</span></label>
                    <select id="condicion" aria-placeholder="condicion" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Dedicacion<span class="obligatorio">*</span></label>
                    <select id="" aria-placeholder="" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="">Ingrese una opcion</option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Categoria<span class="obligatorio">*</span></label>
                    <select id="" aria-placeholder="" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="">Ingrese una opcion</option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <div class="formulario__grupo" id="">
                    <label for="" class="formulario__label">Profesion<span class="obligatorio">*</span></label>
                    <select id="" aria-placeholder="" class="selector formulario__input" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="">Ingrese una opcion</option>
                    </select>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                    <p class="formulario__input-error">Validacion</p>
                </div>

                <div class="formulario__mensaje" id="formulario__mensaje">
                    <p><i class="fas fa-exclamation-triangle"></i> <b>Error:</b> Por favor rellena el formulario correctamente. </p>
                </div>
                <div class="formulario__grupo formulario__grupo-btn-enviar">
                    <button type="submit" class="formulario__btn">Guardar</button>
                    <p class="formulario__mensaje-exito" id="formulario__mensaje-exito">Formulario enviado exitosamente!</p>
                </div>

            </form>

            <button onclick="window.dialog.close();"
                class="x"
                aria-label="Cerrar formulario de tutor">
                ❌
            </button>
        </dialog>
    </div>

    <!-- Tabla de tutores -->
    <div class="table-container">
        <table class="w3-table-all w3-hoverable" aria-label="Listado de tutores">
            <thead>
                <tr class="w3-light-grey">
                    <th scope="col">Cédula</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Profesión</th>
                    <th scope="col" colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody id="datos"></tbody>
        </table>
    </div>

</div>

<script src="js/estudiante/jquery-3.7.0.min.js"></script>
<script src="js/estudiante/main.js"></script>

<?php
require 'footer.php';
