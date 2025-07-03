import {FC} from "react";
import {Header} from "../components/header";
import {Example} from "../pages/example";


export const PageContainer : FC = () => {

    return (
        <>
            <Header/>
            <Example/>
        </>
    )
}
