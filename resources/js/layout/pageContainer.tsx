import { FC, Suspense, lazy } from "react";
import {Header} from "../components/header";
import "./../../css/app.css"


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
