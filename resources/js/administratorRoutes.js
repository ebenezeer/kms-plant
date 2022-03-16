import PlantName from "./components/administrator/PlantName";
import PlantVariety from "./components/administrator/Variety";
import Home from "./components/administrator/Home";
import Register from './components/administrator/Register';


export default [
    {
        path: '/admin/register',
        component: Register,
        name: 'Register',
    },
    {
        path:'/admin/home',
        component: Home,
        name: 'Home',
    },
    {
        path: '/admin/plant',
        name: 'Manage Plant Name',
        component: PlantName
    },
    {
        path: '/admin/variety',
        name: 'Plant Variety',
        component: PlantVariety
    }
]



