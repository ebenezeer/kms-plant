
import Home from "./components/usercontrol/Home";

import PlantDetail from './components/usercontrol/plantdetails/PlantDetail';

export default [
    {
        path: '/user-view/home',
        component: Home,
        name: 'Home',
    },
    {
        path: '/user-view/plant-details/:id',
        component: PlantDetail,
        name: "Plant Details"
    }
]



