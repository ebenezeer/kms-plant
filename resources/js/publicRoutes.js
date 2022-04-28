
import Home from "./components/publicuser/Home";

import SearchIndex from "./components/publicuser/SearchIndex";

import PlantDetail from './components/publicuser/plantdetails/PlantDetail';
// import PlantDetailIndex from "./components/expert/p lantdetails/PlantDetailIndex";
// import PlantDetailsTable from "./components/expert/plantdetails/PlantDetailsTable";
import MethodSearch from "./components/publicuser/graftmet/MethodSearch";

export default [
    {
        path: '/publicuser/home',
        component: Home,
        name: 'Home',
    },
    {
        path: '/search/index',
        component: SearchIndex,
        name: 'Search',
    },
    {
        path: '/public/search-method/:id',
        component: MethodSearch,
        name: "MethodSearch"
    },
    {
        path: '/public/search-plant-details/:id',
        component: PlantDetail,
        name: "Plant Details"
    },
]



