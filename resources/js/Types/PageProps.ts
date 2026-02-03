import { IAuthProps } from "./AuthProps";
import { PageProps as InertiaPageProps } from '@inertiajs/core'

export interface IPageProps extends InertiaPageProps  {
    auth: IAuthProps
}