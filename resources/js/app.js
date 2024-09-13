import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router'; // Importa o router criado

import phoneMaskDirective from './phone-mask-directive';

const app = createApp(App);

// Importa os componentes
import ExampleComponent from './components/ExampleComponent.vue';
import ListProducts from './components/admin/ListProducts.vue';
import ImportProducts from './components/admin/ImportProducts.vue';
import Header from './components/admin/Header.vue';

// Registra os componentes globalmente
app.component('example-component', ExampleComponent);
app.component('list-products', ListProducts);
app.component('import-products', ImportProducts);
app.component('header-admin', Header);


// Registra a diretiva globalmente
app.directive('phone-mask', phoneMaskDirective);


// Usa o Vue Router na aplicação Vue
app.use(router);


// Monta a aplicação no elemento com id 'app'
app.mount('#app');
