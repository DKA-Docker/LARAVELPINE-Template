import { FC, Suspense, lazy } from "react";
import { Header } from "@res/components/header";


const Example = lazy(() => import("./../pages/example"));

export const PageContainer : FC = () => {

    return (
        <>
            <Header/>
            <Suspense fallback={<h3>Loading ....</h3>}>
                <Example/>
            </Suspense>
        </>
    )
}
