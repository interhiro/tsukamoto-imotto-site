const questions = [
  {q:'いつ頃までに不動産を売却したいですか？', a:[['半年以上かかっても、できるだけ良い条件で売却したい','buy'],['できれば3か月以内など、早めに売却したい','bank'],['売却時期をまだ決められていない','consult']]},
  {q:'売却価格と売却までの早さでは、どちらを優先しますか？', a:[['時間がかかっても、少しでも高く売りたい','buy'],['多少価格が低くなっても、早く確実に売りたい','bank'],['どちらを優先すべきか決められない','consult']]},
  {q:'売却する不動産はどのような状態ですか？', a:[['比較的きれいで、そのまま内覧してもらえる','buy'],['築年数が古い、傷みがある、修繕が必要だと思う','bank'],['建物の状態が良いか悪いか、自分では判断できない','consult']]},
  {q:'内覧や片付けへの対応について、どのように考えていますか？', a:[['時間を調整し、片付けや内覧にも対応できる','buy'],['内覧や片付けをできるだけ避け、そのまま売りたい','bank'],['遠方に住んでいるなど、どこまで対応できるか分からない','consult']]},
  {q:'今回、不動産を売却する主な理由は何ですか？', a:[['住み替えや資産整理のため、計画的に売却したい','buy'],['維持費や管理負担を減らすため、早く手放したい','bank'],['相続、離婚、共有名義など、複数の事情が関係している','consult']]},
  {q:'名義や住宅ローンについて、現在の状況に近いものはどれですか？', a:[['本人の単独名義で、売却代金などでローンを完済できると思う','buy'],['本人の単独名義で、早く売却してローンや費用を整理したい','bank'],['共有名義、相続登記前、ローン滞納など、確認すべき問題がある','consult']]},
  {q:'不動産売却で最も優先したいことは何ですか？', a:[['できるだけ高く、納得できる価格で売却すること','buy'],['時間や手間を抑え、早く売却を完了すること','bank'],['自分の状況に合う方法を、専門家と一緒に考えること','consult']]}
];
let current = 0;
let scores = {buy:0, bank:0, consult:0};
const qNum = document.getElementById('qNum');
const qText = document.getElementById('qText');
const options = document.getElementById('options');
const progress = document.getElementById('progress');
const quiz = document.getElementById('quiz');
const result = document.getElementById('result');
const resultTitle = document.getElementById('resultTitle');
const resultText = document.getElementById('resultText');
const stepList = document.getElementById('stepList');
const formCard = document.getElementById('contact');
const formBtn1 = document.getElementById('formBtn1');
const formBtn2 = document.getElementById('formBtn2');
const formBtn3 = document.getElementById('formBtn3');
function initSteps(){
  stepList.innerHTML = '<div class="side-title">クリック診断</div>';
  const names = ['売却時期','価格とスピード','物件の状態','内覧・片付け','売却理由','権利・ローン','優先したいこと'];
  names.forEach((name,i)=>{
    const div=document.createElement('div');
    div.className='side-step'+(i===current?' active':'');
    div.innerHTML='<span>0'+(i+1)+'</span><b>'+name+'</b>';
    stepList.appendChild(div);
  });
}
function renderQuestion(){
  initSteps();
  qNum.textContent = 'Q' + (current+1);
  qText.textContent = questions[current].q;
  options.innerHTML = '';
  questions[current].a.forEach((op,idx)=>{
    const btn = document.createElement('button');
    btn.className = 'option';
    btn.innerHTML = '<strong>' + ['A','B','C'][idx] + '：' + op[0] + '</strong><span>選択</span>';
    btn.addEventListener('click',()=>answer(op[1]));
    options.appendChild(btn);
  });
  progress.textContent = '質問 ' + (current+1) + ' / ' + questions.length;
}
let answers = {};
function answer(type){
  answers[current] = type;
  scores[type]++;
  current++;
  if(current < questions.length){
    renderQuestion();
  } else {
    showResult();
  }
}
function showResult(){
  quiz.style.display='none';
  result.style.display='block';
  initSteps();
  let top;

  if (answers[5] === 'consult') {
        top = 'consult';
  } else {
        const sorted = Object.entries(scores).sort((a, b) => b[1] - a[1]);
        if (sorted.length > 1 && sorted[0][1] === sorted[1][1]
        ) {
            top = 'consult';
        } else {
            top = sorted[0][0];
        }
  }
  
    const data = {
        buy: {
            title: '診断結果：あなたには「仲介」がおすすめです',
            text: '売却まで一定の時間を確保でき、価格を重視しているあなたには、仲介が向いている可能性があります。不動産会社が広告や紹介を通じて購入希望者を探し、市場価格に近い条件での売却を目指します。物件の魅力を整理し、時間をかけて条件に合う買主を探したい方に適した方法です。'
        },
        bank: {
            title: '診断結果：あなたには「買取」がおすすめです',
            text: '売却価格だけでなく、早さや手間の少なさを重視しているあなたには、買取が向いている可能性があります。不動産会社が買主となるため、一般の購入希望者を探す期間や、複数回の内覧が原則として必要ありません。売却時期を明確にし、早く不動産を整理したい方に適した方法です。'
        },
        consult: {
            title: '診断結果：まずは代表の楠本への相談がおすすめです',
            text: '現在は、仲介と買取のどちらかをすぐに決めるより、物件やご事情を整理することが大切です。相続、共有名義、住宅ローン、建物状態など、複数の要素が関係している可能性があります。アイモットの代表が直接お話を伺い、現在確認すべき内容と、考えられる選択肢を一つずつ整理します。'
        }
    };
   
  resultTitle.textContent = data[top].title;
  resultText.textContent = data[top].text;
  if(top === 'buy'){
    formBtn1.innerHTML = '高く売りたい方へ';
    formBtn2.innerHTML = '仲介売却について<br class="sp440">詳しく見る';
    formBtn3.innerHTML = '無料査定を依頼する';
    formBtn1.href = '../sell/high.html';
    formBtn2.href = '../sell/guide/';
    formBtn3.href = '../contact/';
    //formCard.style.display='none';
  }else if(top === 'bank'){
    formBtn1.innerHTML = '早く売りたい方へ';
    formBtn2.innerHTML = '買取について<br class="sp440">詳しく見る';
    formBtn3.innerHTML = '買取査定を依頼する';
    formBtn1.href = '../sell/guide.html';
    formBtn2.href = '../sell/guide/#guide_ttl_01';
    formBtn3.href = '../sell/guide/#guide_ttl_02';
  }else{
    formBtn1.innerHTML = '代表の楠本へ<br class="sp440">無料相談する';
    formBtn2.innerHTML = '不動産の無料査定を<br class="sp440">依頼する';
    formBtn3.innerHTML = '代表紹介を見る';
    formBtn1.href = '../contact/';
    formBtn2.href = '../contact/';
    formBtn3.href = '../company/message.html';
  }
}
document.getElementById('restartBtn').addEventListener('click',()=>{
  current=0;scores={buy:0,bank:0,consult:0};
  result.style.display='none';
  quiz.style.display='block';
  //formCard.style.display='none';
  renderQuestion();
});
renderQuestion();