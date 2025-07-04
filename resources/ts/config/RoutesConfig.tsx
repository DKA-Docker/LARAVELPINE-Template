import { createBrowserRouter, RouteObject } from "react-router-dom";
import {PageContainer} from "@res/layout/pageContainer";
import * as React from "react";
import Example from "@res/pages/example";

const RoutesConfig : Array<RouteObject> = [
    {
        path: '/',
        element : <PageContainer/>,
        children: [
            {
                index: true,
                element: <Example/>
            }
        ]
    }
]

export default createBrowserRouter(RoutesConfig)
