import firebase from 'firebase'

if (!firebase.apps.length) {
  firebase.initializeApp(
    {
      apiKey: "AIzaSyCzsL9Le7RwIO2CMqEnxpvSWp9nQxvKrLQ",
      authDomain: "shareapp-3409c.firebaseapp.com",
      projectId: "shareapp-3409c",
      storageBucket: "shareapp-3409c.appspot.com",
      messagingSenderId: "898559107820",
      appId: "1:898559107820:web:959c052559ab513d7c3bc9",
      measurementId: "G-2SRZ6H07XT"
    }
  )
}
  
export default firebase