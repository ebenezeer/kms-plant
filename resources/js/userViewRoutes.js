
import Home from "./components/usercontrol/Home";

import PlantDetailIndex from './components/usercontrol/plantdetails/PlantDetailIndex';
import PlantDetail from './components/usercontrol/plantdetails/PlantDetail';

import MethodView from './components/usercontrol/graftmet/MethodView';

export default [
    {
        path: '/user-view/home',
        component: Home,
        name: 'Home',
    },
    {
        path: '/user-view/plant-details',
        component: PlantDetailIndex,
        name: "Plant Details"
    },
    {
        path: '/user-view/method-details/:id',
        component: MethodView,
        name: 'Methods'
    },
    {
        path: '/user-view/plant-details/:id',
        component: PlantDetail,
        name: "Plant Details"
    }
]



