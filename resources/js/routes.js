import administratorRoutes from './administratorRoutes.js';
import expertRoutes from './expertRoutes.js';
import publicRoutes from './publicRoutes.js';
import Home from './components/publicuser/Home';
import PlantDetail from './components/publicuser/plantdetails/PlantDetail';


export default {
    mode: 'history',
    //linkActiveClass: 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-blue-600',
    routes: [

        {
            path: '/',
            component: Home,
            name: "Home"
        },
        // {
        //     path: '/home',
        //     component: Home,
        //     name: "Home"
        // },
        {
            path: '/plant-details/:id',
            component: PlantDetail,
            name: "Plant Details"
        },
        ...administratorRoutes,
        ...expertRoutes,
        ...publicRoutes
        // {
        //     path: '/about',
        //     component: Aboutindex,
        //     // name: "",
        //     children: [
        //         {
        //             path: '',
        //             name: 'About',
        //             component: About
        //         },
        //         {
        //             path: 'create',
        //             name: 'Create',
        //             component: Createtest
        //         }
        //     ]
        // },

        // {
        //     path: '/login',
        //     component: Login,
        //     name: 'Login'
        // },


    ]
}