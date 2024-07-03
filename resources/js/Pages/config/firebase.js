// Import the functions you need from the SDKs you need
import { router } from '@inertiajs/react';
import { initializeApp } from "firebase/app";
import { getFirestore } from "@firebase/firestore";
import { getAuth, GoogleAuthProvider, signInWithPopup } from "firebase/auth";
import axios from 'axios';

const firebaseConfig = {
  apiKey: "AIzaSyDEXWXgE_Rx44YPhlnH7fIHMfHwmQsRQhI",
  authDomain: "spygame-2fce3.firebaseapp.com",
  projectId: "spygame-2fce3",
  storageBucket: "spygame-2fce3.appspot.com",
  messagingSenderId: "841856303776",
  appId: "1:841856303776:web:b580fb85f1e3e34c573fc5"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

export const auth = getAuth(app);

const provider = new GoogleAuthProvider();

export const signInWithGoogle = () => {
  signInWithPopup(auth, provider)
    .then((result) => {
      const name = result.user.displayName;
      const email = result.user.email;
      const profilePic = result.user.photoURL;

      localStorage.setItem("name", name);
      localStorage.setItem("email", email);
      localStorage.setItem("profilePic", profilePic);

      axios
      .post('https://auth.blobsandtrees.online/login-with-google', {'email': email, 'name': name,})
      .then((data) => {
        console.log('User logged in with Google', data);
        router.visit("/", {
          user: data.user,
        });
      })
      .catch((error) => {
        console.error("Error loggin in with Google", error);
      });
    })
    .catch((error) => {
      console.error("Error loggin in with Google", error);
    });
};

export const db = getFirestore(app);