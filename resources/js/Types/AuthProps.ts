import { IClinica } from "./Clinica"
import { IFlashMessages } from "./FlashMessages"
import { IUser } from "./User"

export interface IAuthProps {
    user: IUser
    clinica?: IClinica | null
    permissions: string[]
    flash: IFlashMessages
}