using backend_dotnet.Models;
using backend_dotnet.Services;
using backend_dotnet.Services.Interfaces;
using Microsoft.AspNetCore.Mvc;

namespace backend_dotnet.Controllers
{
    [ApiController]
    [Route("v1/[controller]")]
    public class MateriaController : ControllerBase
    {
        private readonly IMateriaService _materiaService;

        public MateriaController(IMateriaService materiaService)
        {
            _materiaService = materiaService;
        }

        [HttpGet("ListarMaterias")]
        public async Task<IActionResult> RetornaMateriasAsync()
        {
            var materias = await _materiaService.RetornaTodasMateriasAsync();
            return Ok(materias);
        }

        [HttpGet("BuscarMateriaPorId/{idMateria}")]
        public async Task<IActionResult> RetornaMateriaPorIdAsync(int idMateria)
        {
            var materia = await _materiaService.RetornaMateriaPorIdAsync(idMateria);
            if(materia == null) return NotFound();
            return Ok(materia);
        }

        [HttpGet("BuscarMateriaPorNome/{nomeMateria}")]
        public async Task<IActionResult> RetornaMateriaPorNomeAsync(string nomeMateria)
        {
            var materia = await _materiaService.RetornaMateriaPorNomeAsync(nomeMateria);
            if(materia == null) return NotFound();
            return Ok(materia);
        }

        [HttpPost("CadastrarMateria")]
        public async Task<IActionResult> CadastrarMateriaAsync(Materia materia)
        {
            var resultado = await _materiaService.CadastrarMateria(materia);
            if(!resultado) return BadRequest("Não foi possível cadastrar a matéria. Verifique se o nome já existe ou se os dados estão corretos.");
            return Ok("Matéria cadastrada com sucesso!");
        }

         [HttpPut("AtualizarMateria/{idMateria}")]
         public async Task<IActionResult> AtualizaMateriaAsync(Materia materia, int idMateria)
        {
            materia.IdMateria = idMateria;

            var materiaAtualizado = await _materiaService.AtualizaMateriaAsync(materia);
            return Ok(materiaAtualizado);
        }

        [HttpDelete("DeletarMateria/{idMateria}")]
        public async Task<IActionResult> DeletarMateriaAsync(int idMateria)
        {
            var resultado = await _materiaService.DeletarMateria(idMateria);
            if(!resultado) return NotFound("Matéria não encontrada para exclusão.");
            return Ok("Matéria deletada com sucesso!");
        }

    }
}
