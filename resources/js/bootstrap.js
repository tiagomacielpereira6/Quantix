// resources/js/bootstrap.js

// Importa Axios (para hacer peticiones HTTP)
import axios from 'axios';

// Configuración global de Axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import _ from 'lodash';
window._ = _;

