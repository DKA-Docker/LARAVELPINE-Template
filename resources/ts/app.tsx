import * as React from 'react'
import * as ReactDOM from 'react-dom/client'
import { PageContainer } from "@res/layout/pageContainer";
import "@css/app.css"

// Render ke elemen dengan id 'app'
const rootElement = document.getElementById('root')
if (rootElement) {
    const root = ReactDOM.createRoot(rootElement)
    root.render(<PageContainer/>)
}
