import { useForm } from "react-hook-form";
import Button from "../components/common/Button";

type TFormData = {
  email: string;
  password: string;
}

export default function Login() {
    const { register, handleSubmit } = useForm<TFormData>();
    
    const handleSave = (data: TFormData) => {
    console.log(data);
    }

  return (
    <main className="w-full h-screen bg-background flex flex-col items-center">
        <div className="w-xl h-auto p-4 mt-50 text-center">
            <h2 className="text-4xl uppercase mb-5">Couple's wish list</h2>
            <p className="text-center mb-10">kmasfdosognroengorengoernmgosmfkosdmopndsopgnspadnposdgopa</p>
        </div>
        
        <div className="w-xl h-auto p-4">
            <form className="bg-background text-text flex flex-col items-center" action="" onSubmit={handleSubmit(handleSave, (errors) => console.log(errors))}>
                <div className="w-full">
                <label htmlFor="email" className="uppercase">email</label>
                <input
                    className="py-3 uppercase rounded-md mb-4 mt-3 w-full" 
                    placeholder="name@example.com" 
                    type="email" 
                    id="email" 
                    {...register("email")} />
                </div>
                
                <div className="w-full">
                    <div className="flex justify-between">
                        <label htmlFor="password" className="uppercase">Password</label>
                        <a className="text-blue-500 hover:underline" href="#">Forgot password?</a>
                    </div>
                    <input
                        className="py-3 uppercase rounded-md mb-4 mt-3 w-full" 
                        placeholder="Password" 
                        type="password" 
                        id="password" 
                        {...register("password")} />
                </div>

                <Button className="m-auto" name="Log In" type="submit" />
            </form>
        </div>    
    </main>
  )
}