import { FC, Suspense, lazy } from "react";
import {Header} from "../components/header";


const Example = lazy(() => import("./../pages/example"));

export const PageContainer : FC = () => {

    return (
        <>
            <Header/>
            <Suspense>
                <Example/>
            </Suspense>

        </>
    )
}
