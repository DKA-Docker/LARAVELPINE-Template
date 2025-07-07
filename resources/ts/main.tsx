import * as React from 'react'
import * as ReactDOM from 'react-dom/client'
import {RouterProvider} from "react-router-dom";
import RoutesConfig from "@res/config/RoutesConfig";

// Render ke elemen dengan id 'app'
const rootElement = document.getElementById('root')
if (rootElement) {
    const root = ReactDOM.createRoot(rootElement)
    root.render(
        <React.StrictMode>
            <RouterProvider router={RoutesConfig}/>
        </React.StrictMode>
    )
}
