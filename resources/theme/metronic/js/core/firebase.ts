// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyBy_jmKX6mIQOVSUSxra5DnVfFSAel3RIE",
    authDomain: "hndgs-65ce6.firebaseapp.com",
    projectId: "hndgs-65ce6",
    storageBucket: "hndgs-65ce6.firebasestorage.app",
    messagingSenderId: "1078964933148",
    appId: "1:1078964933148:web:6f733f7f2264c0f8f245d9",
    measurementId: "G-W472DNVMSB"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
