import PlantName from "./components/administrator/PlantName";
import PlantVariety from "./components/administrator/Variety";
import Home from "./components/administrator/Home";
import Register from './components/administrator/Register';

import PlantDetailIndex from "./components/administrator/plantdetails/PlantDetailIndex";
import PlantDetailsTable from "./components/administrator/plantdetails/PlantDetailsTable";
import CreateDetails from "./components/administrator/plantdetails/CreateDetails";


export default [
    {
        path: '/admin/register',
        component: Register,
        name: 'Register',
    },
    {
        path: '/admin/home',
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
    },
    {
        path: '/admin/plant-detail',
        // name: 'Plant Detail Index',
        component: PlantDetailIndex,
        children: [
            {
                path: '',
                name: 'Plant Detail',
                component: PlantDetailsTable
            },
            {
                path: 'create',
                component: CreateDetails
            },

        ]
    }
]



