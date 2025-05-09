<?php
session_start();

// Inicializar la sesión de roles si no existe
if (!isset($_SESSION['roles'])) {
    $_SESSION['roles'] = [];
}

// Variable para mensaje
$mensaje = '';
$tituloModal = 'Registro de Rol';
$rol_editar = null;

// Función para agregar un rol
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'crear') {
    $rol = [
        'nombre' => $_POST['nombre'],
        'descripcion' => $_POST['descripcion'],
        'estado' => $_POST['estado'],
    ];
    $_SESSION['roles'][] = $rol;
    
    // Redirigir después de crear para evitar reenvío del formulario
    header("Location: roles.php?mensaje=creado");
    exit;
}

// Función para editar un rol
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'editar') {
    $id = $_POST['id'];
    if (isset($_SESSION['roles'][$id])) {
        $_SESSION['roles'][$id] = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'],
            'estado' => $_POST['estado'],
        ];
        
        // Redirigir después de editar para evitar reenvío del formulario
        header("Location: roles.php?mensaje=editado");
        exit;
    }
}

// Función para eliminar un rol
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    
    // Verificar que el índice existe
    if (isset($_SESSION['roles'][$id])) {
        // Eliminar el rol
        unset($_SESSION['roles'][$id]);
        // Reindexar el array para evitar huecos en los índices
        $_SESSION['roles'] = array_values($_SESSION['roles']);
        
        // Redirigir después de eliminar
        header("Location: roles.php?mensaje=eliminado");
        exit;
    }
}

// Verificar si estamos editando un rol
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    if (isset($_SESSION['roles'][$id])) {
        $rol_editar = $_SESSION['roles'][$id];
        $rol_editar['id'] = $id;
        $tituloModal = 'Editar Rol';
    }
}

// Verificar mensaje
if (isset($_GET['mensaje'])) {
    switch ($_GET['mensaje']) {
        case 'creado':
            $mensaje = 'Rol creado correctamente';
            break;
        case 'editado':
            $mensaje = 'Rol actualizado correctamente';
            break;
        case 'eliminado':
            $mensaje = 'Rol eliminado correctamente';
            break;
    }
}

// Determinar si se debe mostrar el modal
$mostrarModal = isset($_GET['edit']) || isset($_GET['nuevo']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THE ROCK</title>
    <link rel="stylesheet" href="./css/styler.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Paginacion -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/bs5/dt-2.2.1/datatables.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
</head>

<body>
    <!-- Topbar -->
    <div class="topbar">
        <div class="logo-container">
            <a href="index.html"><img src="./img/sin fondo 1.png" alt="Logo" class="logo"></a>
            <span class="logo-text">The rock gym center</span>
        </div>
        <div class="user-info">
            <span class="user-name">Anthony Erreyes</span>
            <img src="#" alt="Usuario" class="user-avatar">
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>OPCIONES</h4>
        </div>

        <!-- Menú principal -->
        <ul class="sidebar-menu">
            <li>
                <a href="#" class="menu-item">
                    <i class="fas fa-users"></i>
                    <span>Usuarios</span>
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <ul class="submenu active"> <!-- La clase active se mantiene aquí según la estructura original -->
                    <li><a href="./usuario.php">Usuarios</a></li>
                    <li><a href="./roles.php">Roles</a></li> <!-- Actualizado a roles.php -->
                    <li><a href="./permisos.html">Permisos</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="menu-item">
                    <i class="fas fa-id-card"></i>
                    <span>Membresía</span>
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <ul class="submenu">
                    <li><a href="./membresias.html">Membresias</a></li>
                    <li><a href="./membre-usua.html">Membresias-Usuarios</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="menu-item">
                    <i class="fas fa-box"></i>
                    <span>Inventario</span>
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <ul class="submenu">
                    <li><a href="./producto.html">Productos</a></li>
                    <li><a href="./categorias.html">Categorias</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="menu-item">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Ventas</span>
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <ul class="submenu">
                    <li><a href="./ventas.html">Ventas</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="menu-item">
                    <i class="fas fa-money-bill"></i>
                    <span>Ingresos</span>
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <ul class="submenu">
                    <li><a href="./ingresos.html">Ingresos</a></li>
                    <li><a href="./detalle-ingreso.html">Detalle de Ingresos</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4">LISTADO DE ROLES</h2>
            
            <?php if (!empty($mensaje)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="roles.php?nuevo=1" class="btn btn-primary">Nuevo Rol</a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (isset($_SESSION['roles']) && is_array($_SESSION['roles']) && count($_SESSION['roles']) > 0): 
                            foreach ($_SESSION['roles'] as $index => $rol): 
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($rol['nombre'] ?? '') ?></td>
                            <td><?= htmlspecialchars($rol['descripcion'] ?? '') ?></td>
                            <td><?= htmlspecialchars($rol['estado'] ?? '') ?></td>
                            <td>
                                <a href="roles.php?edit=<?= $index ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="roles.php?delete=<?= $index ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este rol?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php 
                            endforeach;
                        else:
                        ?>
                        <tr>
                            <td colspan="4" class="text-center">No hay roles registrados</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Formulario Modal (mostrado con PHP) -->
    <?php if ($mostrarModal): ?>
    <div class="modal" style="display: block; background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><?= $tituloModal ?></h5>
                    <a href="roles.php" class="btn-close btn-close-white" aria-label="Close"></a>
                </div>
                <form method="POST" action="roles.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= isset($rol_editar['id']) ? $rol_editar['id'] : '' ?>">
                        <input type="hidden" name="action" value="<?= isset($rol_editar) ? 'editar' : 'crear' ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre *</label>
                                <input type="text" class="form-control" name="nombre" value="<?= isset($rol_editar['nombre']) ? htmlspecialchars($rol_editar['nombre']) : '' ?>" required>
                            </div>
                             <div class="col-md-6">
                                <label class="form-label">Estado *</label>
                                <select class="form-control" name="estado" required>
                                    <option value="Activo" <?= (isset($rol_editar['estado']) && $rol_editar['estado'] == 'Activo') ? 'selected' : '' ?>>Activo</option>
                                    <option value="Inactivo" <?= (isset($rol_editar['estado']) && $rol_editar['estado'] == 'Inactivo') ? 'selected' : '' ?>>Inactivo</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="3"><?= isset($rol_editar['descripcion']) ? htmlspecialchars($rol_editar['descripcion']) : '' ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="roles.php" class="btn btn-secondary">Cerrar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>