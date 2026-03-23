namespace backend_dotnet.Models.Requests
{
    public class AtualizarMateriaRequest
    {
        public int IdMateria { get; set; }
        public string NomeMateria { get; set; }
        public int SituacaoMateria { get; set; }
    }
}
