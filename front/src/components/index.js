import vue from 'vue'

import ComponentAuthLoginIndex from '@/components/Auth/Login/Index'
import IntranetSharedsToast from '@/components/Shareds/Toast/Index'
import IntranetDpoIndex from '@/components/Dashboard/Index'
// ----
vue.component('intranet-shareds-toast', IntranetSharedsToast)
vue.component('intranet-auth-login', ComponentAuthLoginIndex)
vue.component('dpo-index', IntranetDpoIndex)
