using backend_dotnet.Data;
using backend_dotnet.Services.Interfaces;
using System.Security.Cryptography;
using System.Text;

namespace backend_dotnet.Services
{
    public class JitsiService : IJitsiService
    {
        public string GerarLinkSala(string idSalaAula, string materia)
        {
            string dadosOriginais = $"{idSalaAula}_{materia}_{Guid.NewGuid()}";

            string hashGerado = GerarHashCurto(dadosOriginais);

            return $"Profeluno_{hashGerado}";
        }

        private string GerarHashCurto(string input)
        {
            using(MD5 md5 = MD5.Create())
            {
                byte[] inputBytes = Encoding.UTF8.GetBytes(input);
                byte[] hashBytes = md5.ComputeHash(inputBytes);

                // Converte os bytes para uma string hexadecimal e pega os primeiros 20 caracteres
                // para não ficar uma URL gigantesca, mas manter a unicidade.
                return BitConverter.ToString(hashBytes).Replace("-", "").ToLower().Substring(0, 20);
            }
        }
    }
}
