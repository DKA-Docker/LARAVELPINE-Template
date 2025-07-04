import { FC, Suspense, lazy } from "react";
import { Header } from "@res/components/header";
import { Outlet } from "react-router-dom";


const Example = lazy(() => import("./../pages/example"));

export const PageContainer : FC = () => {

    return (
        <>
            <Header/>
            <Suspense fallback={<h3>Loading ....</h3>}>
                <Outlet/>
            </Suspense>
        </>
    )
}
