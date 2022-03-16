
import Home from "./components/expert/Home";
import PlantDetailIndex from "./components/expert/PlantDetailIndex";

import PlantName from "./components/expert/plant/PlantName";

import PlantVariety from "./components/expert/variety/Variety";

import GraftIndx from "./components/GraftIndx";
import GraftTableIndex from "./components/expert/graft/GraftTableIndex";
import GraftTechnique from "./components/expert/graft/GraftTechnique";

import MethodsIndex from "./components/expert/methoddetails/MethodsIndex";
import MethodTable from "./components/expert/methoddetails/MethodTable";
import CreateMethod from "./components/expert/methoddetails/CreateMethod";

export default [
    {
        path: '/expert/home',
        component: Home,
        name: 'Home',
    },

    // {
    //     path: '/expert/plant-detail',
    //     name: 'Plant Detail Index',
    //     component: PlantDetailIndex
    // },
    {
        path: '/expert/plant-name',
        name: 'Plant Name',
        component: PlantName
    },
    {
        path: '/expert/variety',
        name: 'Plant Variety',
        component: PlantVariety
    },
    {
        path: '/expert/graft-details',
        //name: 'Graft Technique',
        component: GraftIndx,
        children: [
            {
                path: '',
                name: 'Graft Detail Index',
                component: GraftTableIndex
            },
            {
                path: ':id/edit',
                component: GraftTechnique
            }
        ]
    },
    {
        path: '/expert/method-details',
        component: MethodsIndex,
        children: [
            {
                path: '',
                name: 'Method Table Index',
                component: MethodTable
            },

            {
                path: 'create',
                component: CreateMethod
            },
            {
                path: ':id/edit',
                component: GraftTechnique
            }
        ]
    }
    // {
    //     path: '/expert/graft-details/:id/edit',
    //     component: GraftTechnique
    // }
    // {
    //     path: '/admin/variety',
    //     name: 'Plant Variety',
    //     component: PlantVariety
    // }
]



