namespace backend_dotnet.Models;

public partial class AlunoSala
{
    public int IdAlunoSala { get; set; }
    public int IdAluno { get; set; }
    public int IdSalaAula { get; set; }
    public DateTime? JoinedAt { get; set; }
    public DateTime? LeftAt { get; set; }
    public DateTime? CreatedAt { get; set; }
    public DateTime? UpdatedAt { get; set; }
    public virtual SalaAula SalaAula { get; set; } = null!;
}
