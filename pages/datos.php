<?php
require_once '../classes/service.class.php';

$catalogo = [
    new Service(1, "Desarrollo web", "Creación de páginas y aplicaciones web", 650, "Desarrollo de aplicaciones"),
    new Service(2, "Desarrollo móvil", "Aplicaciones móviles nativas", 1200, "Desarrollo de aplicaciones"),
    new Service(3, "Desarrollo backend", "Construcción de la lógica del servidor, APIs y manejo de bases de datos", 500, "Desarrollo de aplicaciones"),
    new Service(4, "QA y Testing", "Pruebas de calidad para asegurar que el software funcione correctamente", 800, "Desarrollo de aplicaciones"),
    new Service(5, "Arquitectura Cloud", "Diseño y migración de servidores físicos a la nube", 2600, "Infraestructura y Cloud"),
    new Service(6, "DevOps", "Automatización de procesos para que el software se despliegue de forma eficiente", 450, "Infraestructura y Cloud"),
    new Service(7, "Administración de sistemas", "Gestión de servidores, virtualización y almacenamiento de datos. ", 700, "Infraestructura y Cloud"),
    new Service(8, "Auditorías y pentesting", "Simulacros de ataques para encontrar vulnerabilidades en una red o app.", 450, "Ciberseguridad"),
    new Service(9, "Cumplimiento normativo", "Adaptar los sistemas a leyes de protección de datos (GDPR, por ejemplo).", 450, "Ciberseguridad"),
    new Service(10, "Respuesta a incidentes", "Recuperación de datos tras ataques de ransomware o hackeos.", 450, "Ciberseguridad"),
    new Service(11, "Ciencia de datos", "Análisis de grandes volúmenes de datos para predecir tendencias.", 450, "Datos e inteligencia artificial"),
    new Service(12, "Implementación de IA", "Integración de chatbots, modelos de lenguaje (LLMs) y automatización con IA generativa.", 450, "Datos e inteligencia artificial"),
    new Service(13, "Business Intelligence", "Creación de tableros de control (Dashboards) para que las empresas tomen decisiones basadas en datos.", 450, "Datos e inteligencia artificial"),
    new Service(14, "Help Desk", "Soporte técnico remoto o presencial para empleados (problemas de Windows, impresoras, software).", 450, "Soporte y servicios administrativos"),
    new Service(15, "Mantenimiento preventivo", "Limpieza técnica de hardware y actualización de parches de seguridad.", 450, "Soporte y servicios administrativos"),
    new Service(16, "Gestión de redes", "Instalación y configuración de WiFi, firewalls, switches y cableado estructurado.", 450, "Soporte y servicios administrativos"),
];