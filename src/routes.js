import Error404 from './pages/Error404'
import Home from './pages/Home';
import Integrations from './pages/Integrations';
import Docs from './pages/Docs';
import Support from "./pages/Support";
import LoginRegister from "./pages/LoginRegister";

export default {
    base: '/app/',
    mode: 'history',
    linkActiveClass: 'font-bold text-lg',
    routes: [
        {
            path: '*',
            component: Error404
        },
        {
            path: '/',
            component: Home
        },
        {
            path: '/home',
            component: Home
        },
        {
            path: '/integrations',
            component: Integrations
        },
        {
            path: '/docs',
            component: Docs
        },
        {
            path: '/support',
            component: Support
        },
        {
            path: '/login-register',
            component: LoginRegister
        }
    ]
}
